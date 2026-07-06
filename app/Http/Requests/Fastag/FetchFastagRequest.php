<?php

namespace App\Http\Requests\Fastag;

use App\Services\Fastag\FastagBankService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FetchFastagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_number' => ['required', 'string', 'regex:/^[A-Za-z]{2}[0-9]{1,2}[A-Za-z]{1,3}[0-9]{1,4}$/'],
            'issuer_bank' => ['required', Rule::in(array_column(app(FastagBankService::class)->all(), 'value'))],
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_number.regex' => 'Enter a valid vehicle number, e.g. MH12AB1234.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'vehicle_number' => strtoupper(str_replace(' ', '', (string) $this->vehicle_number)),
        ]);
    }
}
