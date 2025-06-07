<?php

namespace App\Http\Requests;

use App\Enums\ResponseTone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommunicationSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'response_tone' => [
                'required',
                Rule::in(ResponseTone::values()),
            ],
            'auto_send_sms' => [
                'boolean',
            ],
            'call_forward_enabled' => [
                'boolean',
            ],
            'auto_send_sms_after_voicemail' => [
                'boolean',
            ],
            'call_ring_duration' => [
                'required',
                'numeric',
                'min:1',
            ],
            'voicemail_message' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}