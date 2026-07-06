<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AccountBlockedException;
use App\Exceptions\InvalidOtpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginMobileRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function create(): View
    {
        return view('auth.login');
    }

    public function requestOtp(LoginMobileRequest $request): JsonResponse
    {
        try {
            $this->authService->requestOtp($request->validated('mobile'));
        } catch (AccountBlockedException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json([
            'message' => 'OTP sent to your mobile number.',
            'demo_otp' => '000000',
        ]);
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        try {
            $this->authService->verifyOtpAndLogin(
                $request->validated('mobile'),
                $request->validated('otp'),
                (bool) $request->boolean('remember'),
            );
        } catch (InvalidOtpException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (AccountBlockedException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        $request->session()->regenerate();

        return response()->json(['redirect' => route('dashboard')]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
