<?php

namespace App\Http\Requests\Admin;

use App\Traits\ResponseCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterAdminRequest extends FormRequest
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
            "firstname" => "required|string",
            "lastname" => "required|string",
            "password" => "required",
            "phone" => "required|numeric|unique:users,phone",
            "email" => "required|unique:users,email",
            "date_of_birth" => 'required|date|date_format:d-m-Y|before:'.now()->subYears(18)->toDateString(),
            "team_role_id" => "required",
        ];
    }


    public function messages(): array
    {
        return [
            "name" => "name is required",
            "password" => "password is required",
            "gender" => "gender is required",
            "phone" => "phone is required",
            "email" => "email is required",
            "date_of_birth" => "Date of Birth is required",
            "team_role_id" => "Team Role ID is required",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->errorsToObjectFormat($validator);
    }
}
