<?php

namespace App\Services\Recharge;

class RechargeOperatorService
{
    /**
     * @return array<int, array{value: string, label: string}>
     */
    public function all(): array
    {
        return [
            ['value' => 'jio', 'label' => 'Jio'],
            ['value' => 'airtel', 'label' => 'Airtel'],
            ['value' => 'vi', 'label' => 'Vi'],
            ['value' => 'bsnl', 'label' => 'BSNL'],
        ];
    }

    public function label(string $value): string
    {
        return collect($this->all())->firstWhere('value', $value)['label'] ?? 'Unknown';
    }
}
