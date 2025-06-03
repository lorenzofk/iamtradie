<?php

namespace App\Http\Requests\Billing;

use App\Enums\ResponseTone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSessionCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                'array',
            ],
            'user.first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'user.email' => [
                'required',
                'email',
                'max:255',
            ],
            'settings' => [
                'required',
                'array',
            ],
            'settings.business_name' => [
                'required',
                'string',
                'max:255',
            ],
            'settings.industry_type' => [
                'required',
                'string',
                'max:255',
            ],
            'settings.callout_fee' => [
                'required',
                'numeric',
                'min:0',
                'max:1000'
            ],
            'settings.hourly_rate' => [
                'required',
                'numeric',
                'min:0',
                'max:500'
            ],
            'settings.response_tone' => [
                'required',
                Rule::in(ResponseTone::values())
            ],
        ];
    }
}
