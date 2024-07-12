<?php

namespace App\Http\Requests\Admin\Permissions;

use App\Traits\ResponseCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreatePermissionRequest  extends FormRequest
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
            'user_roles_id' => 'required',
            'role_id' => 'required'
        ];
    }


    public function failedValidation(Validator $validator)
    {
        $this->errorsToObjectFormat($validator);
    }
}
