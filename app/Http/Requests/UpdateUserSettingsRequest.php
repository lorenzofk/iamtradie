<?php

namespace App\Http\Requests;

use App\Enums\IndustryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserSettingsRequest extends FormRequest
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
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . auth()->id(),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
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
            'response_tone' => [
                'required',
                Rule::in(['casual', 'polite', 'professional']),
            ],
            'preferred_cta' => [
                'nullable',
                'string',
                'max:500',
            ],
            'auto_send_email' => [
                'boolean',
            ],
        ];
    }
}