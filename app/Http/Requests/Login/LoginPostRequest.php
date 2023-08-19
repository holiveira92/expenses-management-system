<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Login\ValidPassword;

class LoginPostRequest extends FormRequest
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
            'email' => ["required", "exists:users,email"],
            'password' => ["required", new ValidPassword()],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is a required field',
            'email.exists' => 'Email not found in system',
            'password.required' => 'Password is a required field',
        ];
    }

}
