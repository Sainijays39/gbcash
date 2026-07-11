<?php

namespace App\Services\Recharge;

class RechargeOperatorService
{
    /**
     * `value` is the real BillAvenue billerId for each Mobile Prepaid operator.
     * Jio/Airtel/Vi codes are BillAvenue's Prepaid Recharge product codes (per
     * their Prepaid Recharge API doc); BSNL comes from the general BBPS biller
     * master since it isn't part of that product-specific set.
     *
     * @return array<int, array{value: string, label: string}>
     */
    public function all(): array
    {
        return [
            ['value' => 'BILAVJIO000001', 'label' => 'Jio'],
            ['value' => 'BILAVAIRTEL001', 'label' => 'Airtel'],
            ['value' => 'BILAVVODA00001', 'label' => 'Vi'],
            ['value' => 'BSNL00000NATHL', 'label' => 'BSNL'],
        ];
    }

    public function label(string $value): string
    {
        return collect($this->all())->firstWhere('value', $value)['label'] ?? 'Unknown';
    }
}
