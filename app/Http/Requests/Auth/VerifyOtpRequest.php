<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/', 'exists:users,mobile'],
            'otp' => ['required', 'digits:6'],
            'remember' => ['sometimes', 'boolean'],
        ];
    }
}
