<?php

namespace App\Http\Requests\Fastag;

class RechargeFastagRequest extends FetchFastagRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'amount' => ['required', 'numeric', 'min:50', 'max:50000'],
        ]);
    }
}
