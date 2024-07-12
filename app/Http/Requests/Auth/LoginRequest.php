<?php

namespace App\Http\Requests\Auth;

use App\Traits\ResponseCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "phone" => "required",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->errorsToObjectFormat($validator);
    }
}
