<?php

namespace App\Services\Auth;

use App\Enums\UserStatus;
use App\Exceptions\AccountBlockedException;
use App\Exceptions\InvalidOtpException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
        private readonly OtpService $otpService,
    ) {}

    public function register(array $data): User
    {
        return $this->users->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'state' => $data['state'],
            'status' => UserStatus::Active,
        ]);
    }

    /**
     * Issue an OTP for the given mobile number.
     *
     * @throws AccountBlockedException
     */
    public function requestOtp(string $mobile): User
    {
        $user = $this->users->findByMobile($mobile);

        if ($user->status === UserStatus::Blocked) {
            throw new AccountBlockedException;
        }

        $this->otpService->generateFor($user);

        return $user;
    }

    /**
     * Verify OTP and authenticate the user.
     *
     * @throws InvalidOtpException
     * @throws AccountBlockedException
     */
    public function verifyOtpAndLogin(string $mobile, string $otp, bool $remember = false): User
    {
        $user = $this->users->findByMobile($mobile);

        if ($user->status === UserStatus::Blocked) {
            throw new AccountBlockedException;
        }

        if (! $this->otpService->verify($user, $otp)) {
            throw new InvalidOtpException;
        }

        $this->otpService->clear($user);

        Auth::login($user, $remember);

        return $user;
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
