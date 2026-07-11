<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ChangeEmailRequest;
use App\Http\Requests\Profile\RequestMobileOtpRequest;
use App\Http\Requests\Profile\UpdateMobileRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\Auth\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private readonly OtpService $otpService) {}

    public function index(): View
    {
        return view('profile.index', [
            'states' => config('states'),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Auth::user()->update($request->validated());

        return back()->with('status', 'Profile updated successfully.');
    }

    public function updateEmail(ChangeEmailRequest $request): RedirectResponse
    {
        Auth::user()->update(['email' => $request->validated('email')]);

        return back()->with('status', 'Email updated successfully.');
    }

    /**
     * Step 1 of changing mobile number: validate the new number and send an OTP to it.
     */
    public function requestMobileOtp(RequestMobileOtpRequest $request): JsonResponse
    {
        $mobile = $request->validated('mobile');

        $this->otpService->generateFor(Auth::user());

        session(['pending_mobile' => $mobile]);

        return response()->json([
            'message' => 'OTP sent to your new mobile number.',
            'demo_otp' => '000000',
        ]);
    }

    /**
     * Step 2: verify the OTP and commit the mobile number change.
     */
    public function updateMobile(UpdateMobileRequest $request): JsonResponse
    {
        $user = Auth::user();
        $mobile = $request->validated('mobile');

        if (session('pending_mobile') !== $mobile) {
            return response()->json(['message' => 'Please request a new OTP for this mobile number.'], 422);
        }

        if (! $this->otpService->verify($user, $request->validated('otp'))) {
            return response()->json(['message' => 'The OTP you entered is invalid or has expired.'], 422);
        }

        $this->otpService->clear($user);
        $user->update(['mobile' => $mobile]);
        session()->forget('pending_mobile');

        return response()->json(['message' => 'Mobile number updated successfully.']);
    }
}
