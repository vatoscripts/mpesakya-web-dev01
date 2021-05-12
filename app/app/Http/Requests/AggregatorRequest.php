<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AggregatorRequest extends FormRequest
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
        if ($this->is('api/aggregator/onboard/first')) {
            return $this->aggregatorOnboardFirstRules();
        }
        // Check if Login rules
        elseif ($this->is('api/aggregator/onboard/second')) {
            return $this->aggregatorOnboardSecondRules();
        }

    }

    public function aggregatorOnboardFirstRules()
    {
        return [
            'NIN' => 'required | digits:20',
            'fingerCode' => 'required',
            'fingerData' => 'required'
        ];
    }

    private function aggregatorOnboardSecondRules()
    {
        return [
            'TINFile' => 'required|mimes:jpeg,jpg,png|max:200',
            'aggregatorTerritory' => 'required',
            'businessName' => 'required',
            'TIN' => 'required|numeric',
            'businessLicence' => 'required',
            'aggregatorTerritory' => 'required',
            'mobilePhone' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
            'aggregatorPhone' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
            'businessLicenceFile' => 'required|mimes:jpeg,jpg,png|max:200',
            'aggregatorEmail' => 'required|email',
            'shortCode' => 'required',
            'aggregatorCategory' => 'required',
            'aggregatorAdress' => 'required',
        ];
    }

    public function messages()
    {
        return [
            /** AGGREGATOR ONBOARD Page1*/
            'NIN.required' => 'Please Input Aggregator\'s NIDA ID !',
            'NIN.digits' => 'Invalid Aggregator\'s NIDA ID Format !',
            'fingerCode.required' => 'Please Select Aggregator\'s finger index !',
            'fingerData.required' => 'Please Capture Aggregator\'s finger print !',

            /** AGGREGATOR ONBOARD Page2*/
            'TINFile.required' => 'Please input Aggregator\'s TIN file !',
            'TINFile.mimes' => 'TIN file must be in PNG, JPG or JPEG format !',
            'TINFile.max' => 'TIN file size MUST not exceed 200KB  !',

            'businessName.required' => 'Please input Aggregator business name !',
            'TIN.required' => 'Please input Aggregator\'s business TIN number !',
            'TIN.numeric' => 'Please input Aggregator\'s business TIN MUST be a number !',

            'businessLicence.required' => 'Please input Aggregator \'s business licence number !',
            'aggregatorTerritory.required' => 'Please input Aggregator \'s business territory number !',
            'mobilePhone.required' => 'Please input Aggregator \'s mobile phone number !',
            'mobilePhone.regex' => 'Incorrect Aggregator \'s mobile phone number format !',
            'aggregatorPhone.required' => 'Please input Aggregator \'s business phone number !',
            'aggregatorPhone.regex' => 'Incorrect Aggregator \'s business phone number format !',

            'businessLicenceFile.required' => 'Please input Aggregator\'s business licence file !',
            'businessLicenceFile.mimes' => 'Business licence file must be in PNG, JPG or JPEG format !',
            'businessLicenceFile.max' => 'Business licence file size MUST not exceed 200KB  !',
            'aggregatorEmail.required' => 'Please input Aggregator \'s email adress !',
            'aggregatorEmail.email' => 'Incorrect Aggregator \'s email adress format !',
            'shortCode.required' => 'Please input Aggregator \'s short code !',
            'aggregatorTerritory.required' => 'Please select Aggregator territory !',
            'aggregatorAdress.required' => 'Please input Aggregator adress !',

        ];
    }
}
