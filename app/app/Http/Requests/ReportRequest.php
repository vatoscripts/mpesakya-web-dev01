<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
        // Check if Bulk Registration rules Page 1
        if ($this->is('api/reports')) {
            return $this->verificationReport();
        }
    }

    private function verificationReport()
    {
        return [
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'reportCategory' => 'required',
        ];
    }

    public function messages()
    {
        return [
            /**  REGISTRATION REPORTS **/
            'startDate.required' => 'Please select start date !',
            'endDate.after_or_equal' => 'End date should be greater or equal to start date  !',
            'endDate.required' => 'Please select end date !',
            'reportCategory.required' => 'Please select report category !',
        ];
    }
}
