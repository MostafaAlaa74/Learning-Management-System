<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:204800', // max 200MB
            'assignments' => 'nullable|file|mimes:pdf,docx|max:255',
            'presentations' => 'nullable|file|mimes:pptx,pdf|max:2000',
            
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The lesson title is required.',
            'video.required' => 'A video file is required for the lesson.',
            'video.mimes' => 'The video must be a file of type: mp4, mov, avi, wmv.',
            'video.max' => 'The video size must not exceed 200MB.',
            'assignments.mimes' => 'The assignments file must be a PDF or DOCX.',
            'assignments.max' => 'The assignments file size must not exceed 255KB.',
            'presentations.mimes' => 'The presentations file must be a PPTX.',
            'presentations.max' => 'The presentations file size must not exceed 2MB.',
            
        ];
    }
}
