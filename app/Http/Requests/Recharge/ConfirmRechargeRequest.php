<?php

namespace App\Http\Requests\Recharge;

use App\Services\Recharge\RechargeService;
use Illuminate\Validation\Validator;

class ConfirmRechargeRequest extends FetchPlansRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'plan_id' => ['required', 'string'],
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($this->filled('plan_id') && ! app(RechargeService::class)->findPlan($this->input('plan_id'))) {
                $validator->errors()->add('plan_id', 'The selected plan is invalid.');
            }
        });
    }
}
