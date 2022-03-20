<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'semester_type' => ['required', 'string', 'in:First,Second'],
            'year_level' => ['required', 'integer', 'min:1', 'max:4']
        ];
    }
}
