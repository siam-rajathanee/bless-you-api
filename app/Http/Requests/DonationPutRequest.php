<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationPutRequest extends FormRequest
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
            'firstname' => 'string',
            'lastname' => 'string',
            'donate' => 'string',
            'amount' => 'numeric',
            'status' => 'in:approved,rejected',
            'address_allow' => 'nullable|boolean',
            'address' => 'string',
            'subdistrict' => 'string',
            'district' => 'string',
            'province' => 'string',
            'zip_code' => 'string',
        ];
    }
}
