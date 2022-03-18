<?php

namespace App\Http\Requests\Registrar;

use Carbon\Carbon;
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
            'first_name' => ['required', 'string', 'min:4'],
            'last_name' => ['required', 'string', 'min:4'],
            'birthed_at' => ['required', 'date', 'before:18 years ago'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
        ];
    }
}
