<?php

namespace App\Http\Requests\Expenses;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Expenses\VerifyIsOwnerUser;

class CreateRequest extends FormRequest
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
            'description' => ["required", "string", "max:191"],
            'occurrence_date' => ["required", "date", "date_format:Y-m-d", "before:tomorrow"],
            'user_id' => ["required", "integer", "exists:users,id", new VerifyIsOwnerUser()],
            'value' => ["required", "numeric", "gt:0"],
        ];
    }

    public function messages()
    {
        return [
        ];
    }
    
}
