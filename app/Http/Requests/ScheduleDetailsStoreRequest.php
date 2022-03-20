<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleDetailsStoreRequest extends FormRequest
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
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'professor_id' => ['required', 'integer', 'exists:professors,id'],
            'day' => ['required', 'string', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'],
            'from' => ['required'],
            'to' => ['required', 'after:from']
        ];
    }
}
