<?php

namespace App\Services\Electricity;

class ElectricityProviderService
{
    /**
     * `value` is the real BillAvenue/BBPS billerId — sent as-is in Bill Fetch /
     * Bill Payment API calls, no separate internal-to-real mapping needed.
     *
     * @return array<int, array{value: string, label: string}>
     */
    public function all(): array
    {
        return [
            ['value' => 'MAHA00000MAH01', 'label' => 'MSEDCL (Maharashtra)'],
            ['value' => 'RELI00000MUM03', 'label' => 'Adani Electricity Mumbai'],
            ['value' => 'TATAPWR00MUM01', 'label' => 'Tata Power - Mumbai'],
            ['value' => 'TORR00000NATLX', 'label' => 'Torrent Power'],
            ['value' => 'BESCOM000KAR01', 'label' => 'BESCOM (Bangalore)'],
            ['value' => 'TNEB00000TND01', 'label' => 'TNPDCL (Tamil Nadu)'],
            ['value' => 'PSPCL0000PUN01', 'label' => 'PSPCL (Punjab)'],
            ['value' => 'UPPC00000UTPAH', 'label' => 'UPPCL (Uttar Pradesh)'],
            ['value' => 'WEST00000WBL75', 'label' => 'West Bengal Electricity (WBSEDCL)'],
            ['value' => 'KSEBL0000KER01', 'label' => 'KSEBL (Kerala)'],
        ];
    }

    public function label(string $value): string
    {
        return collect($this->all())->firstWhere('value', $value)['label'] ?? $value;
    }

    public function exists(string $value): bool
    {
        return collect($this->all())->contains('value', $value);
    }
}
