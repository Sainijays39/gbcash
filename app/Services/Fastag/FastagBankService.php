<?php

namespace App\Services\Fastag;

class FastagBankService
{
    /**
     * `value` is the real BillAvenue/BBPS billerId — sent as-is in Bill Fetch /
     * Bill Payment API calls, no separate internal-to-real mapping needed.
     *
     * Note: Paytm Payments Bank was excluded (RBI barred it from issuing new
     * FASTags in 2024, and it's absent from BillAvenue's current biller master).
     *
     * @return array<int, array{value: string, label: string}>
     */
    public function all(): array
    {
        return [
            ['value' => 'TOLL00000NAT72', 'label' => 'ICICI FASTag'],
            ['value' => 'HDFC00000NAT5K', 'label' => 'HDFC FASTag'],
            ['value' => 'SBIB00000NAT25', 'label' => 'SBI FASTag'],
            ['value' => 'AXIS00000NAT31', 'label' => 'Axis FASTag'],
            ['value' => 'IDFC00000NATXM', 'label' => 'IDFC FIRST FASTag'],
            ['value' => 'KOTA00000NATJZ', 'label' => 'Kotak FASTag'],
            ['value' => 'AUBA00000NATOF', 'label' => 'AU FASTag'],
            ['value' => 'THEF00000NATZO', 'label' => 'Federal FASTag'],
            ['value' => 'INDU00000NATR2', 'label' => 'IndusInd FASTag'],
            ['value' => 'PUNJ00022NATNO', 'label' => 'PNB FASTag'],
        ];
    }

    public function label(string $value): string
    {
        return collect($this->all())->firstWhere('value', $value)['label'] ?? 'Unknown';
    }
}
