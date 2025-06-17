<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranscriptionRequest extends FormRequest
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
            'From' => [
                'required',
                'string',
            ],
            'Called' => [
                'required',
                'string',
            ],
            'CallSid' => [
                'required',
                'string',
            ],
            'TranscriptionText' => [
                'required',
                'string',
                'max:10000',
            ],
        ];
    }

    /**
     * Get the caller's phone number from the request.
     */
    public function getCaller(): string
    {
        return $this->input('From');
    }

    /**
     * Get the called number (Twilio number) from the request.
     */
    public function getCalled(): string
    {
        return $this->input('Called');
    }

    /**
     * Get the call SID from the request.
     */
    public function getCallSid(): string
    {
        return $this->input('CallSid');
    }

    /**
     * Get the transcription text from the request.
     */
    public function getTranscription(): string
    {
        return $this->input('TranscriptionText');
    }
} 