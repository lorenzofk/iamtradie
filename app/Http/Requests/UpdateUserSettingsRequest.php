<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'industry_type' => 'required|in:electrical,plumbing,tiling,carpentry,painting,general',
            'callout_fee' => 'required|numeric|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'response_tone' => 'required|in:casual,polite,professional',
            'preferred_cta' => 'nullable|string|max:500',
            'auto_send_sms' => 'boolean',
            'auto_send_email' => 'boolean',
            'twilio_number' => 'nullable|string|max:20',
        ];
    }
}