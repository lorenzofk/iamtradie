<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+]?[1-9][\d]{0,15}$/'
            ],
            'message' => [
                'required',
                'string',
                'max:1600'
            ]
        ];
    }
}
