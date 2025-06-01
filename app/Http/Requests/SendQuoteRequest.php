
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20|regex:/^[\+]?[1-9][\d]{0,15}$/',
            'project_description' => 'nullable|string|max:1000',
            'estimated_hours' => 'nullable|numeric|min:0',
            'materials_cost' => 'nullable|numeric|min:0',
            'additional_notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_phone.regex' => 'Please enter a valid phone number.',
            'estimated_hours.numeric' => 'Estimated hours must be a number.',
            'materials_cost.numeric' => 'Materials cost must be a number.',
        ];
    }
}
