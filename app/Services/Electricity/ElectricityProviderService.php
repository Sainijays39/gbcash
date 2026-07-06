<?php

namespace App\Services\Electricity;

class ElectricityProviderService
{
    /**
     * @return array<int, array{value: string, label: string}>
     */
    public function all(): array
    {
        return [
            ['value' => 'msedcl', 'label' => 'MSEDCL'],
            ['value' => 'adani', 'label' => 'Adani Electricity'],
            ['value' => 'tata_power', 'label' => 'Tata Power'],
            ['value' => 'torrent_power', 'label' => 'Torrent Power'],
            ['value' => 'bescom', 'label' => 'BESCOM'],
            ['value' => 'tangedco', 'label' => 'TANGEDCO'],
            ['value' => 'pspcl', 'label' => 'PSPCL (Punjab)'],
            ['value' => 'uppcl', 'label' => 'UPPCL (Uttar Pradesh)'],
            ['value' => 'wbsedcl', 'label' => 'WBSEDCL (West Bengal)'],
            ['value' => 'others', 'label' => 'Others'],
        ];
    }

    public function label(string $value): string
    {
        return collect($this->all())->firstWhere('value', $value)['label'] ?? 'Others';
    }

    public function exists(string $value): bool
    {
        return collect($this->all())->contains('value', $value);
    }
}
