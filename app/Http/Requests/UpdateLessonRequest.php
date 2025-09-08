<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'video' => 'sometimes|file|mimes:mp4,mov,avi,wmv|max:204800', // max 200MB
            'course_id' => 'sometimes|exists:courses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'The lesson title must be a string.',
            'title.max' => 'The lesson title must not exceed 255 characters.',
            'video.file' => 'The video must be a file.',
            'video.mimes' => 'The video must be a file of type: mp4, mov, avi, wmv.',
            'video.max' => 'The video size must not exceed 200MB.',
            'course_id.exists' => 'The selected course does not exist.',
        ];
    }
}
