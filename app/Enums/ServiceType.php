<?php

namespace App\Enums;

enum ServiceType: string
{
    case Electricity = 'electricity';
    case Fastag = 'fastag';
    case Recharge = 'recharge';

    public function label(): string
    {
        return match ($this) {
            self::Electricity => 'Electricity Bill',
            self::Fastag => 'Fastag Recharge',
            self::Recharge => 'Mobile Recharge',
        };
    }
}
