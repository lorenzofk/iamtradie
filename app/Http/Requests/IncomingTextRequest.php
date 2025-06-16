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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'Body' => [
                'required',
                'string',
                'max:1600',
            ],
            'To' => [
                'required',
                'string',
            ],
            'From' => [
                'required',
                'string',
            ],
            'SmsMessageSid' => [
                'required',
                'string',
            ],
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
