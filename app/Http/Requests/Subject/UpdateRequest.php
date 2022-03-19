<?php

namespace App\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'code' => ['required', 'string', 'unique:subjects,code,' . $this->subject_id],
            'name' => ['required', 'string', 'unique:subjects,name,' . $this->subject_id],
            'units' => ['required', 'integer', 'min:1', 'max:6']
        ];
    }
}
