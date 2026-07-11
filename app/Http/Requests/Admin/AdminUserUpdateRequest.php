<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/', Rule::unique('users', 'mobile')->ignore($this->route('user'))],
            'state' => ['required', Rule::in(config('states'))],
        ];
    }
}
