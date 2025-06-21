<?php

declare(strict_types=1);

namespace App\Http\Requests\Billing;

use App\Enums\IndustryType;
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
                'unique:users,email',
            ],
            'user.mobile' => [
                'required',
                'string',
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
                Rule::in(IndustryType::values()),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user.email.unique' => 'An account with this email already exists. Please use a different email or try logging in.',
            'user.first_name.required' => 'Please enter your first name.',
            'user.mobile.required' => 'Please enter your mobile number.',
            'settings.business_name.required' => 'Please enter your business name.',
            'settings.industry_type.required' => 'Please select your trade type.',
        ];
    }
}
