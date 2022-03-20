<?php

namespace App\Http\Requests\Student;

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
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'email' => ['required', 'email', 'unique:users'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'guardian' => ['required', 'string'],
            'contact_number' => ['required', 'string'],
            'birthed_at' => ['required', 'date', 'before:18 years ago']
        ];
    }
}
