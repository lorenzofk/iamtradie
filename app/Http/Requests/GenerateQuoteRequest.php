<?php

namespace App\Http\Requests;

use App\Enums\ResponseTone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_message' => [
                'required',
                'string',
                'max:2000',
            ],
            'location' => [
                'nullable',
                'string',
                'max:200'
            ],
            'job_type' => [
                'nullable',
                'string',
                'max:100'
            ],
            'callout_fee' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000'
            ],
            'hourly_rate' => [
                'nullable',
                'numeric',
                'min:0',
                'max:500'
            ],
            'response_tone' => [
                'nullable',
                Rule::in(ResponseTone::values())
            ],
            'preferred_cta' => [
                'nullable',
                'string',
                'max:500'
            ]
        ];
    }
}
