<?php

namespace App\Http\Requests\Expenses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use App\Rules\Expenses\VerifyIsOwnerUser;

class UpdateRequest extends FormRequest
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
            'description' => ["sometimes", "string", "max:191"],
            'occurrence_date' => ["sometimes", "date", "date_format:Y-m-d", "before:tomorrow"],
            'user_id' => ["sometimes", "integer", "exists:users,id", new VerifyIsOwnerUser()],
            'value' => ["sometimes", "numeric", "gt:0"],
        ];
    }

    public function messages()
    {
        return [
        ];
    }
    
}
