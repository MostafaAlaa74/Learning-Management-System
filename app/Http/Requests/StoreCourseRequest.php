<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:40',
            'description' => 'sometimes|string|max:500',
            'price' => 'required|numeric|regex:/^[1-9][0-9]+/|min:0'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The Title Is Required',
            'title.min' => 'The Min Is 2 Characters',
            'title.max' => 'The max Is 40 Characters',
            'description.max' => 'The max Is 500 Characters'
        ];
    }
}
