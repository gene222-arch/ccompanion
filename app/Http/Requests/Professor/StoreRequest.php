<?php

namespace App\Http\Requests\Professor;

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
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'prefix' => ['required', 'string', 'min:3'],
            'employment_type' => ['required', 'string', 'in:Full-time Employment,Part-time Employment'],
            'first_name' => ['required', 'string', 'min:3'],
            'last_name' => ['required', 'string', 'min:3'],
            'birthed_at' => ['required', 'date', 'before:18 years ago'],
            'subject_ids' => ['required', 'array'],
            'subject_ids.*' => ['required', 'integer', 'distinct', 'exists:subjects,id']
        ];
    }
}
