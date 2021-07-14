<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationPostRequest extends FormRequest
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
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'donate' => 'required',
            'amount' => 'required|numeric',
            'proof_of_transfer' => 'required',
            'address_allow' => 'nullable|boolean',
            'address' => 'exclude_unless:address_allow,true|required',
            'subdistrict' => 'exclude_unless:address_allow,true|required',
            'district' => 'exclude_unless:address_allow,true|required',
            'province' => 'exclude_unless:address_allow,true|required',
            'zip_code' => 'exclude_unless:address_allow,true|required',
        ];
    }
}
