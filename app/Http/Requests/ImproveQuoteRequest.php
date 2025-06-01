
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImproveQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'original_response' => 'required|string|max:2000',
            'improvements' => 'required|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'original_response.required' => 'Original response is required for improvement.',
            'original_response.max' => 'Original response cannot exceed 2000 characters.',
            'improvements.required' => 'Improvement suggestions are required.',
            'improvements.max' => 'Improvement suggestions cannot exceed 1000 characters.'
        ];
    }
}
