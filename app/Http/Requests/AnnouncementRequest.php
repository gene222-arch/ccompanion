<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
            'image' => ['required', 'image'],
            'header' => ['required', 'string', 'min:5'],
            'subheader' => ['required', 'string', 'min:5'],
            'body' => ['required', 'string', 'min:10']
        ];
    }
}
