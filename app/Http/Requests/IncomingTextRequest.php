<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomingTextRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: Add Twilio webhook signature validation here for security
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'Body' => 'required|string|max:1600', // SMS body text
            'To' => 'required|string', // Twilio number (agent SMS number)
            'From' => 'required|string', // Lead's phone number
            'SmsMessageSid' => 'required|string', // Twilio SMS ID
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'Body' => 'message body',
            'To' => 'Twilio number',
            'From' => 'sender number',
            'SmsMessageSid' => 'SMS ID',
        ];
    }

    /**
     * Get the message body from the request.
     */
    public function getMessageBody(): string
    {
        return $this->input('Body');
    }

    /**
     * Get the Twilio number (agent SMS number) from the request.
     */
    public function getTwilioNumber(): string
    {
        return $this->input('To');
    }

    /**
     * Get the lead's phone number from the request.
     */
    public function getLeadNumber(): string
    {
        return $this->input('From');
    }

    /**
     * Get the SMS message SID from the request.
     */
    public function getSmsId(): string
    {
        return $this->input('SmsMessageSid');
    }
} 