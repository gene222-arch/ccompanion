<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'string', 'unique:courses'],
            'name' => ['required', 'string', 'unique:courses'],
            'department_id' => ['required', 'integer', 'exists:departments,id']
        ];
    }

    public function messages()
    {
        return [
            'department_id.exists' => 'Selected department does not exists.'
        ];
    }
}
