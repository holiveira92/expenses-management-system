<?php

namespace App\Http\Requests\Expenses;

use Illuminate\Foundation\Http\FormRequest;
use App\Policies\ExpensePolicy;
use App\Rules\Expenses\VerifyIsOwnerUserRule;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ExpensePolicy::userCanCreate($this->user(), $this->user_id);
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
            'user_id' => ["required", "integer", "exists:users,id", new VerifyIsOwnerUserRule()],
            'value' => ["required", "numeric", "gt:0"],
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'description is a required field',
            'description.string' => 'must be a string',
            'description.max' => 'max size limit is 191 characters',

            'occurrence_date.required' => 'occurrence_date is a required field',
            'occurrence_date.date' => 'must be a date',
            'occurrence_date.date_format' => 'date format must be Y-m-d',
            'occurrence_date.before' => 'date must be until today',

            'user_id.required' => 'user_id is a required field',
            'user_id.integer' => 'must be an integer',
            'email.exists' => 'user not found in system',

            'value.required' => 'value is a required field',
            'value.numeric' => 'must be a numeric value',
            'value.gt' => 'value be a number grater than zero',
        ];
    }
    
}
