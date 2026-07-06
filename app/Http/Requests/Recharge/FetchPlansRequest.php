<?php

namespace App\Http\Requests\Recharge;

use App\Services\Recharge\RechargeOperatorService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FetchPlansRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'operator' => ['required', Rule::in(array_column(app(RechargeOperatorService::class)->all(), 'value'))],
        ];
    }

    public function messages(): array
    {
        return [
            'mobile.regex' => 'Enter a valid 10-digit mobile number.',
        ];
    }
}
