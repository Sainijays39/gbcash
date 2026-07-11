<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMobileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                Rule::unique('users', 'mobile')->ignore($this->user()->id),
            ],
            'otp' => ['required', 'digits:6'],
        ];
    }
}
