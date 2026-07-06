<?php

namespace App\Http\Requests\Electricity;

use App\Services\Electricity\ElectricityProviderService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FetchBillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'provider' => ['required', Rule::in(array_column(app(ElectricityProviderService::class)->all(), 'value'))],
            'consumer_number' => ['required', 'string', 'alpha_num', 'min:4', 'max:20'],
        ];
    }
}
