<?php

namespace App\Http\Requests\Auth;

use App\Traits\ResponseCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class IsVerifiedPhoneRequest extends FormRequest
{
    use ResponseCode;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'country_code'  => 'required',
            "phone" => "required|numeric",
            "verify_code" => "required",
        ];
    }


    public function messages(): array
    {
        return [
            "country_code" => "country_code is invalid",
            "phone" => "phone is required"
        ];
    }


    public function failedValidation(Validator $validator)
    {
        $this->errorsToObjectFormat($validator);
    }
}
