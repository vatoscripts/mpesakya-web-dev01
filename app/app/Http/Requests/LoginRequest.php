<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        // Check if Login rules
        if ($this->is('api/auth/login')) {
            return $this->loginRules();
        }
        // Check if OTP rules
        elseif ($this->is('api/auth/otp')) {
            return $this->OtpRules();
        }
        // Check if reset-password rules
        elseif ($this->is('reset-password')) {
            return $this->resetPasswordRules();
        }
        // Check if recover-new-password rules
        elseif ($this->is('api/auth/recover-password')) {
            return $this->recoverNewPasswordRules();
        }
        // Check if recover-password-sms rules
        elseif ($this->is('api/auth/reset-password')) {
            return $this->recoverPasswordSMSRules();
        }
        // Check if create-new-user rules
        elseif ($this->is('create-new-user')) {
            return $this->createNewUserRules();
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Username is required !',
            'password.required' => 'Password is required !',
            'otp.required' => 'OTP is required !',
            'reset_password_email.required' => 'Email is required !',
            'inputpwd1.required' => 'New password is required !',
            'inputpwd2.required' => 'Confirm new password is required !',
            'terms.accepted' => 'You must agree to Vodacom Terms & Conditions !',
            'inputpwdOld.required' => 'Old password is required !',
            'inputpwdNew.required' => 'New password is required !',
            'inputpwdNewConfirm.required' => 'Confirm new password is required !',
            'reset_password_phone.required' => 'Please input your phone number !',
            'reset_password_phone.regex' => 'Invalid phone number. Try Again !',
            'inputpwdNewConfirm.same' => 'New password and confirm new password does not match !',
            'inputpwdNew.regex' => 'Password does not meet minimum security compliance !',
            'otp.digits' => 'Invalid OTP !'
        ];
    }

    public function loginRules()
    {
        return [
            'name' => 'required|string|max:20',
            'password' => 'required',
            'terms' => 'accepted'
        ];
    }

    public function OtpRules()
    {
        return [
            'otp' => 'required|digits:6'
        ];
    }

    public function resetPasswordRules()
    {
        return [
            'reset_password_email' => 'required|string|max:30'
        ];
    }

    public function recoverNewPasswordRules()
    {
        return [
            'inputpwdOld' => 'required|string|max:30',
            'inputpwdNew' => 'required|string|min:10|regex:/^.*(?=.{10,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/',
            'inputpwdNewConfirm' => 'required|string|min:10|max:30|same:inputpwdNew',
        ];
    }

    public function recoverPasswordSMSRules()
    {
        return [
            'reset_password_phone' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
        ];
    }

    private function createNewUserRules()
    {
        return [

        ];
    }
}
