
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_message' => 'required|string|max:2000',
            'location' => 'nullable|string|max:200',
            'job_type' => 'nullable|string|max:100',
            'callout_fee' => 'nullable|numeric|min:0|max:1000',
            'hourly_rate' => 'nullable|numeric|min:0|max:500',
            'response_tone' => 'nullable|in:casual,polite,professional',
            'preferred_cta' => 'nullable|string|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'client_message.required' => 'Client message is required to generate a quote.',
            'client_message.max' => 'Client message cannot exceed 2000 characters.',
            'callout_fee.max' => 'Callout fee cannot exceed $1000.',
            'hourly_rate.max' => 'Hourly rate cannot exceed $500.',
            'response_tone.in' => 'Response tone must be casual, polite, or professional.',
            'preferred_cta.max' => 'Call-to-action message cannot exceed 500 characters.'
        ];
    }
}
