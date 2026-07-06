<?php

namespace App\Services\Fastag;

class FastagBankService
{
    /**
     * @return array<int, array{value: string, label: string}>
     */
    public function all(): array
    {
        return [
            ['value' => 'icici', 'label' => 'ICICI FASTag'],
            ['value' => 'hdfc', 'label' => 'HDFC FASTag'],
            ['value' => 'sbi', 'label' => 'SBI FASTag'],
            ['value' => 'axis', 'label' => 'Axis FASTag'],
            ['value' => 'idfc', 'label' => 'IDFC FASTag'],
            ['value' => 'kotak', 'label' => 'Kotak FASTag'],
            ['value' => 'au', 'label' => 'AU FASTag'],
            ['value' => 'federal', 'label' => 'Federal FASTag'],
            ['value' => 'indusind', 'label' => 'IndusInd FASTag'],
            ['value' => 'paytm', 'label' => 'Paytm FASTag'],
        ];
    }

    public function label(string $value): string
    {
        return collect($this->all())->firstWhere('value', $value)['label'] ?? 'Unknown';
    }
}
