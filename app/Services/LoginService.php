<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public static function HasTwoFactorAuthentication($request)
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

    public static function send2FACode($user)
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

    public static function checkCode($request)
    {
        if ($request->input('2faCode') != session()->get('2fa.2faCode')) {
            throw ValidationException::withMessages([
                '2faCode' => trans('auth.failed'),
            ]);
        }

        Auth::loginUsingId(session()->get('2fa.userId'));
    }
}
