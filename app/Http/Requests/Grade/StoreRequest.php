<?php

namespace App\Http\Requests\Grade;

use App\Models\Grade;
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
        $subjectIDs = Grade::query()
            ->where('schedule_id', $this->schedule_id)
            ->get()
            ->map(fn ($grade) => "subject_id_" . $grade->subject_id);

        $subjectValidation = collect([]);
        
        $subjectIDs->map(function ($subjectID) use ($subjectValidation) {
            $subjectValidation->put($subjectID, ['required', 'min:0', 'max:100']);
        });

        return array_merge($subjectValidation->toArray(), [
            'schedule_id' => ['required', 'integer', 'exists:schedules,id']
        ]);
    }

    public function messages()
    {
        $subjectIDs = Grade::query()
            ->where('schedule_id', $this->schedule_id)
            ->get()
            ->map(fn ($grade) => "subject_id_" . $grade->subject_id);

        $validationMessages = collect([]);
        
        $subjectIDs->map(function ($subjectID) use ($validationMessages) {
            $validationMessages->put("$subjectID.required", 'Subject grade is required.');
            $validationMessages->put("$subjectID.min", 'Input grade must not be less than 0.');
            $validationMessages->put("$subjectID.max", 'Input grade must not be more than 100.');
        });

        return $validationMessages->toArray();
    }
}
