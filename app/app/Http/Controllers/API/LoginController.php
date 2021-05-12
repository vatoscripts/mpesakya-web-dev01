<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\GuzzleController as GuzzleController;
use App\Http\Requests\LoginRequest;
use session;
use Log;

class LoginController extends GuzzleController
{
    public function __construct()
    {
        parent::__constructor();
    }

    public function login(LoginRequest $request)
    {
        $body = [
            'UserName' => $request->name,
            'Password' => $request->password,
            'platform' => 'web',
            'AppVersion' => null
        ];

        $url = 'login';

        $data = $this->postRequest($url, $body);

        unset($body['Password']);

      //  Log::channel('Auth')->debug(['Request' => $body, 'Response' => $data]);

        if (isset($data['Token']) && empty($data['Error'])) {
            $request->session()->put('user', $data);

            return response()->json(['message' => null, 'Response' => $data], 200);
        }
        elseif($data['Code'] == "121" || $data['Code'] == "122") {
            return response()->json(['message' =>'Invalid username or password !', 'Response' => $data], 400);
        }
        elseif($data['Code'] == "123") {
            return response()->json(['message' =>'Your account has been locked !', 'Response' => $data], 400);
        }
        else{
            return response()->json(['message' =>'Sorry, An error has occured !', 'Response' => $data], 400);
        }
    }

    public function validateOTP(LoginRequest $request)
    {
        $body = [
            'ID' => $this->user['UserID'],
            'Description' => $request->otp,
            'IPAddress' => $request->ip()
        ];

        $url = 'otp';

        $data = $this->postRequest($url, $body);

        // Log::channel('Auth')->debug(['Request' => $body, 'Response' => $data]);

        if ($data['ID'] == '0' && $data['Description'] == 'OK') {
            $request->session()->put('Authenticated', TRUE);

            return response()->json(['message' => null, 'Response' => $data], 200);
        }

        return response()->json(['message' =>'Sorry! An Error has occured !', 'Response' => $data], 400);
    }

    public function resendOTP()
    {
        $body = [
            'UserID' => $this->user['UserID'],
            'Email' => $this->user['Email'],
            'Phone' => $this->user['Phone']
        ];

        $url = 'ResendOTP';

        $data = $this->postRequest($url, $body);

        if (isset($data['ID']) && ($data['ID'] == $this->user['UserID'])) {
            if (isset($data['Description']) && $data['Description'] == 'OK') {
                return response()->json(['message' => 'New OTP has been re-send !', 'Response' => $data], 200);
            }
        }

        return response()->json(['message' =>'Sorry ! An Error has occured !', 'Response' => $data], 400);
    }

    public function resetPassword(LoginRequest $request)
    {
        $body = [
            'Msisdn' => $request->get('reset_password_phone'),
        ];

        $url = 'ResetPwdByPhone';

        $data = $this->postRequest($url, $body);

        if ($data['ID'] === 0 && $data['Description'] === null) {
            return response()->json(['message' => 'Your password has been reset !', 'Response' => $data], 200);
        } elseif ($data['Description'] !== null) {
            return response()->json(['message' =>'Wrong phone number !', 'Response' => $data], 400);
        }

        return response()->json(['message' =>'Sorry ! An error has occured !', 'Response' => $data], 400);
    }

    public function recoverPassword(LoginRequest $request)
    {
        $body = [
            'UserID' => $this->user['UserID'],
            'OldPassword' => $request->inputpwdOld,
            'NewPassword' => $request->inputpwdNew,
        ];

        $url = 'ResetDefaultPwd';

        $data = $this->postRequest($url, $body);

        if ($data['ID'] === 1 && $data['Description'] == 'OK') {
            return response()->json(['message' => 'Your password has been reset !', 'Response' => $data], 200);
        }elseif ($data['ID'] == 2 || $data['ID'] == 3) {
            return response()->json(['message' => 'Password has already been used . Please use another !', 'Response' => $data], 400);
        }elseif ($data['ID'] == 0) {
            return response()->json(['message' => 'Wrong password . Please try Again !', 'Response' => $data], 400);
        }

        return response()->json(['message' =>'Sorry ! An error has occured !', 'Response' => $data], 400);
    }

    public function logoutUser()
    {
        $body = ['UserID' => $this->user['UserID']];

        $url = 'LogOut';

        $data = $this->postRequest($url, $body);

      //  Log::channel('Auth')->debug(['Request' => $body, 'Response' => $data]);

        // return json_encode($data);

        // if($data['ID'] !== 0)
        // {
        //     return response()->json(['message' =>'Sorry ! An error has occured !', 'Response' => $data], 400);
        //     //Log::channel('Logout')->emergency(['user' => $this->user['UserName'], 'Request' => $body, 'TimeStamp' =>time(), 'Response' => $data]);
        // }

        session::flush();

        return response()->json(['message' => 'You have been  logged Out !', 'Response' => $data], 200);
    }
}
