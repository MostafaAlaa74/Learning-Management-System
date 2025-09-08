<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'title' => 'sometimes|string|min:2|max:40',
            'description' => 'sometimes|string|max:500',
            'price' => 'sometimes|numeric|regex:/^[1-9][0-9]+/|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least 2 characters.',
            'title.max' => 'The title must not exceed 40 characters.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description must not exceed 500 characters.',
            'price.numeric' => 'The price must be a numeric value.',
            'price.regex' => 'The price must be a positive number without leading zeros.',
            'price.min' => 'The price must be at least 0.',
        ];
    }
}
