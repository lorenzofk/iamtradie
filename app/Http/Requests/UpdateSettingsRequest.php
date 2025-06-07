<?php

namespace App\Http\Requests;

use App\Enums\IndustryType;
use App\Enums\ResponseTone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
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
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . auth()->id(),
            ],
            'business_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'business_location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'phone_number' => [
                'required',
                'string',
                'max:20',
            ],
            'agent_sms_number' => [
                'exclude',
            ],
            'industry_type' => [
                'required',
                Rule::in(IndustryType::values()),
            ],
            'callout_fee' => [
                'required',
                'numeric',
                'min:0',
            ],
            'hourly_rate' => [
                'required',
                'numeric',
                'min:1',
            ],
        ];
    }
}