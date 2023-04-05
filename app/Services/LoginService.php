<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\TwoFARequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 *Provides services for user login, two-factor authentication, and 2FA code verification.
 */
class LoginService
{
    /**
     *Send 2FA code if user has two-factor authentication enabled.
     *
     *@throws ValidationException if login credentials are invalid
     *
     *@return bool True if user does not have 2FA enabled, false send 2FA code
     */
    public static function HasTwoFactorAuthentication(LoginRequest $request): bool
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if (!$user->has_2fa) {
            return true;
        }

        LoginService::send2FACode($user);

        return false;
    }

    /**
     *Sends a two-factor authentication code and put it into session.
     */
    public static function send2FACode(User $user): void
    {
        $twilioCode = mt_rand(100000, 999999);

        TwilioService::sendMessage($twilioCode, $user->phone);

        session([
            '2fa' => [
                'userId' => $user->id,
                '2faCode' => $twilioCode,
            ],
        ]);
    }

    /**
     *Verifies the two-factor authentication code and logins user.
     *
     *@throws ValidationException if the 2FA code is invalid
     */
    public static function checkCode(TwoFARequest $request): void
    {
        if ($request->input('2faCode') != session()->get('2fa.2faCode')) {
            throw ValidationException::withMessages([
                '2faCode' => trans('auth.failed'),
            ]);
        }

        Auth::loginUsingId(session()->get('2fa.userId'));
    }
}
