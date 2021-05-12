<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WakalaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Check if onboard NIDA rules
        if ($this->is('api/wakala/onboard/first')) {
            return $this->wakalaOnboardFirstRules();
        }
        // Check if onboard DB rules
        elseif ($this->is('api/wakala/onboard/second')) {
            return $this->wakalaOnboardSecondRules();
        }
        // Check if onboard Recuiter rules
        elseif ($this->is('api/wakala/onboard/recruiter')) {
            return $this->wakalaOnboardRecruiterRules();
        }
        // Check if Wakala get Contract OTP rules
        elseif ($this->is('api/wakala/onboard/getcontractOTP')) {
            return $this->wakalaContractOTPRules();
        }

        // Check if  Wakala verify Contract OTP rules
        elseif ($this->is('api/wakala/onboard/verify-contractOTP')) {
            return $this->wakalaVerifyContractOTPRules();
        }

        // Check if  Wakala verify Contract OTP rules
        elseif ($this->is('api/wakala/verify')) {
            return $this->wakalaVerifyRules();
        }
    }

    public function wakalaOnboardFirstRules()
    {
        return [
            'NIN' => 'required | digits:20',
            'fingerCode' => 'required',
            'fingerData' => 'required'
        ];
    }

    private function wakalaOnboardSecondRules()
    {
        return [
            'TINFile' => 'required|mimes:jpeg,jpg,png|max:200',
            'wakalaTerritory' => 'required',
            'businessName' => 'required',
            'TIN' => 'required|digits:9',
            'businessLicence' => 'required',
            'wakalaTerritory' => 'required',
            'contactPhone' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
            // 'wakalaPhone' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
            'businessLicenceFile' => 'required|mimes:jpeg,jpg,png|max:200',
            'brelaFile' => 'required_if:businessGroup,1,4||mimes:jpeg,jpg,png|max:200',
            'memartFile' => 'required_if:businessGroup,1||mimes:jpeg,jpg,png|max:200',
            'businessPhone' => 'required',
            'mpesaMobilePhone' => 'required',
            'businessGroup' => 'required',
            'contactName' => 'required',
            'tillNumber' => 'required',
            'shortCode' => 'required',
        ];
    }

    private function wakalaOnboardRecruiterRules()
    {
        return [
            'recruiterPhone' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
            'recruiterNIN' => 'required | digits:20',
            'fingerCode' => 'required',
            'fingerData' => 'required'
        ];
    }

    private function wakalaContractOTPRules()
    {
        return [
            'msisdn' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/'
        ];
    }

    private function wakalaVerifyContractOTPRules()
    {
        return [
            'confirmationCode' => 'required|digits:6'
        ];
    }

    private function wakalaVerifyRules()
    {
        return [
            'RejectComment' => 'required_if:VerificationStatus,3'
        ];
    }

    public function messages()
    {
        return [
            /** wakala ONBOARD Page1*/
            'NIN.required' => 'Please input wakala\'s NIDA ID !',
            'NIN.digits' => 'Invalid wakala\'s NIDA ID Format !',
            'fingerCode.required' => 'Please select wakala\'s finger index !',
            'fingerData.required' => 'Please capture wakala\'s finger print !',

            /** wakala ONBOARD Page2*/
            'TINFile.required' => 'Please input wakala\'s TIN file !',
            'TINFile.mimes' => 'TIN file must be in PNG, JPG or JPEG format !',
            'TINFile.max' => 'TIN file size MUST not exceed 200KB  !',

            'businessName.required' => 'Please input wakala business name !',
            'TIN.required' => 'Please input wakala\'s business TIN number !',
            'TIN.digits' => 'Invalid wakala\'s business TIN number !',

            'businessLicence.required' => 'Please input wakala\'s business licence number !',
            'wakalaTerritory.required' => 'Please input wakala\'s business territory number !',
            'mobilePhone.required' => 'Please input wakala\'s mobile phone number !',
            'mobilePhone.regex' => 'Incorrect wakala\'s mobile phone number format !',
            'wakalaPhone.required' => 'Please input wakala \'s business phone number !',
            'wakalaPhone.regex' => 'Invalid wakala\'s business phone number format !',

            'brelaFile.required_if' => 'Please input wakala\'s BRELA Incorporation file !',
            'brelaFile.mimes' => 'BRELA Incorporation file must be in PNG, JPG or JPEG format !',
            'brelaFile.max' => 'BRELA Incorporation file size MUST not exceed 200KB  !',

            'memartFile.required_if' => 'Please input wakala\'s Memart file !',
            'memartFile.mimes' => 'Memart file must be in PNG, JPG or JPEG format !',
            'memartFile.max' => 'Memart file size MUST not exceed 200KB  !',

            'businessLicenceFile.required' => 'Please input wakala\'s business licence file !',
            'businessLicenceFile.mimes' => 'Business licence file must be in PNG, JPG or JPEG format !',
            'businessLicenceFile.max' => 'Business licence file size MUST not exceed 200KB  !',
            'wakalaEmail.required' => 'Please input wakala\'s email adress !',
            'wakalaEmail.email' => 'Incorrect wakala\'s email adress format !',
            'shortCode.required' => 'Please input wakala\'s short code !',
            'wakalaTerritory.required' => 'Please select wakala territory !',
            'wakalaAdress.required' => 'Please input wakala adress !',

            'msisdn.required' => 'Please input  phone number !',
            'msisdn.regex' => 'Invalid phone number format !',

            'confirmationCode.required' => 'Empty OTP token submitted !',
            'confirmationCode.digits' => 'Invalid OTP token format !',

            /** RECRUITER FIELDS */
            'recruiterPhone.required' => 'Please input recruiter\'s phone number !',
            'recruiterPhone.regex' => 'Incorrect recruiter\'s phone number format !',
            'recruiterNIN.required' => 'Please input Recruiter\'s NIDA ID !',
            'recruiterNIN.digits' => 'Invalid Recruiter\'s NIDA ID Format !',

            /** VERIFY WAKALA */
            'RejectComment.required_if' => 'Please input rejection reason !',
        ];
    }
}
