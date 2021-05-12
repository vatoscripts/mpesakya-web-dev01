<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\GuzzleController as GuzzleController;
use App\Http\Requests\WakalaRequest;
use session;
use Log;

class WakalaController extends GuzzleController
{
    public function __construct()
    {
        parent::__constructor();
        $this->middleware(['role:AGGREGATOR,WAKALA_RECRUITER,TDR'])->except(['viewUnverifiedWakala', 'verifyWakala', 'getApprovedWakala', 'getDeclinedWakala', 'getUnverifiedWakala', 'getWakalaListWithStatus']);
        $this->middleware(['role:ADMIN,MPESA_ADMIN,BACKOFFICE'])->only(['viewUnverifiedWakala', 'verifyWakala', 'getApprovedWakala', 'getDeclinedWakala', 'getUnverifiedWakala', 'getWakalaListWithStatus']);
    }

    public function onboardWakalaNIDA(WakalaRequest $request)
    {
        $body = [
            'NIN' => $request->NIN,
            'FingerCode' => $request->fingerCode,
            'FingerData' => $request->fingerData,
            'platform' => 'web'
        ];

        $url = 'NIDA';

        $data = $this->postRequest($url, $body);

        unset($body['FingerData']);

        Log::channel('Wakala-onboard')->debug(['user' => $this->user['UserName'], 'Request' => $body, 'Response' => $data]);

        if ($data['ErrorCode'] == 0) {
            session::put('WakalaNIDA', $data);
            return response()
                ->json([
                    'message' => null,
                    'status' => $data['ErrorCode']
                ], 200);
        } elseif ($data['ErrorCode'] == '01') {
            return response()
                ->json([
                    'message' => 'Biometric verification failed',
                    'status' => $data['ErrorCode']
                ], 400);
        } elseif ($data['ErrorCode'] == '132') {
            return response()
                ->json([
                    'message' => 'NIN not found',
                    'status' => $data['ErrorCode']
                ], 400);
        } elseif ($data['ErrorCode'] == '141') {
            return response()
                ->json([
                    'message' => 'Biometric fingerprint verification failed 141. Use another finger !',
                    'status' => $data['ErrorCode']
                ], 400);
        } elseif ($data['ErrorCode'] == '-10') {
            return response()
                ->json([
                    'message' => 'NIDA connection error. Try again later !',
                    'status' => $data['ErrorCode']
                ], 400);
        }else {
            return response()
                ->json([
                    'message' => $data['ErrorMessage'],
                    'status' => $data['ErrorCode']
                ], 400);
        }
    }

    public function onboardWakalaDB(WakalaRequest $request)
    {
        $NIDA = $request->session()->get('WakalaNIDA');

        $TINDoc = file_get_contents($request->TINFile);
        $TINDocBase64 = base64_encode($TINDoc);

        $licenceDoc = file_get_contents($request->businessLicenceFile);
        $LicenceDocBase64 = base64_encode($licenceDoc);

        if($request->businessGroup == 1 || $request->businessGroup == 4 )
        {
            $BrelaDoc = file_get_contents($request->brelaFile);
            $BrelaDocBase64 = base64_encode($BrelaDoc);
        } else {
            $BrelaDocBase64 = null;
        }

        if($request->businessGroup == 1)
        {
            $MemartDoc = file_get_contents($request->memartFile);
            $MemartDocBase64 = base64_encode($MemartDoc);
        } else {
            $MemartDocBase64 = null;
        }

        $body = [
            'NIN' => $NIDA['NIN'],
            'OrganizationName' => $request->businessName,
            'MpesaMSISDN' => $request->mpesaMobilePhone,
            'OfficeMSISDN' => $request->businessPhone,
            'MpesaContactName' => $request->contactName,
            'MpesaContactMSISDN' => $request->contactPhone,
            'TIN' => $request->TIN,
            'TINDoc' => $TINDocBase64,
            'BusinessLicenceNo' => $request->businessLicence,
            'BusinessLicenceDoc' => $LicenceDocBase64,
            'NidaTransactionID' => $NIDA['ID'],
            'BrelaCertificate' => $BrelaDocBase64,
            'MEMARTDoc' => $MemartDocBase64,
            'TerritoryID' => (int) $request->wakalaTerritory,
            'BusinessGroupID' => (int) $request->businessGroup,
            'TillNumber' => $request->tillNumber,
            'Shortcode' => $request->shortCode,
            'CreatedBy' => $this->user['UserID'],
            'CategoryID' => 2,
        ];

        $url = 'OnboardWakala';

        $data = $this->postRequest($url, $body);

        unset($body['MEMARTDoc']);
        unset($body['TINDoc']);
        unset($body['BusinessLicenceDoc']);
        unset($body['BrelaCertificate']);

        Log::channel('Wakala-onboard')->debug(['user' => $this->user['UserName'], 'Request' => $body, 'Response' => $data]);

        if($data['ID'] == 0) {
            session::forget('WakalaNIDA');
            return response()
                ->json([
                    'message' => 'Wakala onboarded Succesful !',
                    'status' => $data['Description']
                ], 200);
        }elseif($data['ID'] == 2) {
            return response()
                ->json([
                    'message' => 'Duplicate Till number or ShortCode !',
                    'status' => $data['ID']
                ], 400);
        }elseif($data['ID'] !== 0) {
            return response()
                ->json([
                    'message' => $data['Description'],
                    'status' => $data['ID']
                ], 400);
        }

        return response()
                ->json([
                    'message' => $data['Description'],
                    'status' => $data['ID']
                ], 400);

    }

    public function listWakala()
    {
        $url = 'GetWakalaList/' .  $this->user['UserID'];

        $data = $this->getRequest($url);

        return $data;
    }

    public function onboardWakalaRecruiter(WakalaRequest $request)
    {
        $body = [
            'UserID' => $this->user['UserID'],
            'RecruiterRoleID' => 5,
            'RecruiterPhoneNumber' => $request->recruiterPhone,
            'RecruiterNIN' => $request->recruiterNIN,
            'Fingerprints' =>$request->fingerData,
            'FingerCode' => $request->fingerCode
        ];

        $url = 'CreateWakalaRecruiter';

        $data = $this->postRequest($url, $body);

        unset($body['Fingerprints']);

        Log::channel('Recruiter-onboard')->debug(['user' => $this->user['UserName'], 'Request' => $body, 'Response' => $data]);

        if ($data['ID'] === 0 && $data['Description'] === null) {
            return response()->json(['message' => 'Recruiter onboarded successfully !', 'status' => $data], 200);
        }
        elseif ($data['ID'] == 2) {
            return response()
                ->json([
                    'message' => 'User already exists !',
                    'status' => $data['ID']
                ], 400);
        }
        elseif ($data['ID'] == 4) {
            return response()
                ->json([
                    'message' => 'User NIN already exists !',
                    'status' => $data['ID']
                ], 400);
        }
        elseif ($data['ID'] == '01') {
            return response()
                ->json([
                    'message' => 'Biometric verification failed',
                    'status' => $data['ID']
                ], 400);
        } elseif ($data['ID'] == '132') {
            return response()
                ->json([
                    'message' => 'NIN not found',
                    'status' => $data['ID']
                ], 400);
        } elseif ($data['ID'] == '141') {
            return response()
                ->json([
                    'message' => 'Biometric fingerprint verification failed 141. Use another finger !',
                    'status' => $data['ID']
                ], 400);
        } elseif ($data['ID'] == '-10') {
            return response()
                ->json([
                    'message' => 'NIDA connection error. Try again later !',
                    'status' => $data['ID']
                ], 400);
        }else {
            return response()
                ->json([
                    'message' => 'Sorry, an error has occured !',
                    'status' => $data['ID']
                ], 400);
        }
    }

    public function getContractOTPCode(WakalaRequest $request)
    {
        $body = [
            'UserID' => $this->user['UserID'],
            'WakalaMsisdn' => $request->msisdn,
        ];

        $url = 'ContractConfirmationOTP';

        $data = $this->postRequest($url, $body);

        Log::channel('Wakala-onboard')->debug(['user' => $this->user['UserName'], 'Request' => $body, 'Response' => $data]);

        if ($data['ID'] === 0) {
            $request->session()->put('WakalaMsisdn', $request->msisdn);
            return response()->json(null, 200);
        } elseif ($data['ID'] !== 0) {
            return response()->json(['message' => $data['Description'], 'Response' => $data], 400);
        }

        return response()->json(['message' =>'Sorry ! An error has occured !', 'Response' => $data], 400);
    }

    public function verifyContractOTPCode(WakalaRequest $request)
    {
        $body = [
            'UserID' => $this->user['UserID'],
            'WakalaMsisdn' => $request->session()->get('WakalaMsisdn'),
            'ConfirmationCode' => $request->confirmationCode,
        ];

        $url = 'VerifyConfirmationCode';

        $data = $this->postRequest($url, $body);

        Log::channel('Wakala-onboard')->debug(['user' => $this->user['UserName'], 'Request' => $body, 'Response' => $data]);

        if ($data['ID'] == 0) {
            $request->session()->forget('WakalaMsisdn');
            return response()->json(null, 200);
        } elseif ($data['ID'] !== 0) {
            return response()->json(['message' => $data['Description'], 'Response' => $data], 400);
        }

        return response()->json(['message' =>'Sorry ! An error has occured !', 'Response' => $data], 400);
    }

    public function getUnverifiedWakala()
    {
        $url = 'GetUnverifiedWakalas' ;

        $data = $this->getRequest($url);

        $finalArray = [];

        if(is_array($data)) {
            foreach ($data as $item) {
            $item['CreatedDate'] = date('Y - m - d  G:i:s', strtotime($item['CreatedDate']));
            array_push($finalArray, $item);
            }
            return response()->json($finalArray, 200);
        }
        else {
            return response()->json(null, 400);
        }
    }

    public function viewUnverifiedWakala(Request $request)
    {
        $body = [
            'UserID' => $this->user['UserID'],
            'MpesaAgentID' => $request->agentID,
        ];

        $url = 'GetSingleWakala';

        $data = $this->postRequest($url, $body);

        return response()->json($data, 200);
    }

    public function verifyWakala(WakalaRequest $request)
    {
        $body = [
            'UserID' => $this->user['UserID'],
            'MpesaAgentID' => $request->MpesaAgentID,
            'VerificationStatus' => $request->VerificationStatus,
            'RejectComment' =>  $request->RejectComment,
        ];

        $url = 'VerifyWakala';

        $data = $this->postRequest($url, $body);

        Log::channel('Wakala-verify')->debug(['user' => $this->user['UserName'], 'Request' => $body, 'Response' => $data]);

        if ($data['ID'] == 0) {
            return response()->json(['message' => 'Successful Wakala verification !', 'Response' => $data], 200);
        } elseif ($data['ID'] !== 0) {
            return response()->json(['message' => $data['Description'], 'Response' => $data], 400);
        }

        return response()->json(['message' =>'Sorry ! An error has occured !', 'Response' => $data], 400);
    }

    public function getApprovedWakala()
    {
        $url = 'ListWakalaByStatus/2' ;

        $data = $this->getRequest($url);

        $finalArray = [];

        if(is_array($data)) {
            foreach ($data as $item) {
            $item['VerifiedDate'] = date('Y - m - d  G:i:s', strtotime($item['VerifiedDate']));
            array_push($finalArray, $item);
        }

        return response()->json($finalArray, 200);
        }
        else {
            return response()->json(null, 400);
        }
    }

    public function getDeclinedWakala()
    {
        $url = 'ListWakalaByStatus/3';

        $data = $this->getRequest($url);

        $finalArray = [];

        if(is_array($data)) {
            foreach ($data as $item) {
            $item['RejectedDate'] = date('Y - m - d  G:i:s', strtotime($item['RejectedDate']));
            array_push($finalArray, $item);
            }

        return response()->json($finalArray, 200);
        }
        else {
            return response()->json(null, 400);
        }
    }

    public function getWakalaListWithStatus()
    {
        $url = 'WakalaVerificationStatus';

        $data = $this->getRequest($url);

        if(is_array($data))  {
            return response()->json($data, 200);
        }
        else {
            return response()->json(null, 200);
        }
    }

}
