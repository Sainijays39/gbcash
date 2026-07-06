<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Carbon;

class OtpService
{
    public const DEMO_OTP = '000000';

    public const EXPIRY_MINUTES = 10;

    /**
     * Generate (or in demo mode, assign) an OTP for the given user.
     */
    public function generateFor(User $user): string
    {
        $otp = self::DEMO_OTP;

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(self::EXPIRY_MINUTES),
        ]);

        return $otp;
    }

    public function verify(User $user, string $otp): bool
    {
        if (blank($user->otp) || blank($user->otp_expires_at)) {
            return false;
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return false;
        }

        return hash_equals($user->otp, $otp);
    }

    public function clear(User $user): void
    {
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);
    }
}
