<?php

namespace App\Services;

use App\Http\Requests\TwoFARequest;
use App\Mail\LoginMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

/**
 * The LoginService class provides functionality for authenticating users,
 * sending two-factor authentication codes and verifying them, and sending login
 * confirmation emails.
 */
class LoginService
{
    /**
     * Sends a two-factor authentication code to the specified user's phone number and
     * saves the code in the session for later verification.
     *
     * @param User $user
     *
     * @return void
     */
    public static function send2FACode(User $user): void
    {
        $twilioCode = mt_rand(100000, 999999);

        TwilioService::sendMessage($twilioCode, $user->phone);

        session([
            '2fa' => [
                'user' => $user,
                '2faCode' => $twilioCode,
            ],
        ]);
    }

    /**
     * Verifies the two-factor authentication code and logins user.
     *
     * @param TwoFARequest $request
     *
     * @throws ValidationException if the 2FA code is invalid
     *
     * @return void
     */
    public static function checkCode(TwoFARequest $request): void
    {
        if ($request->input('2faCode') != session()->get('2fa.2faCode')) {
            throw ValidationException::withMessages([
                '2faCode' => trans('auth.failed'),
            ]);
        }

        LoginService::authenticate(session()->get('2fa.user'), $request);
    }

    /**
     * Authenticates the given user and logs them in.
     *
     * @param User        $user
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse the redirect response after a successful login
     */
    public static function authenticate(User $user, FormRequest $request)
    {
        Auth::loginUsingId($user->id);

        LoginService::sendSignEmail($user, $request);

        session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Sends an email to the user that someone signed in to his account.
     *
     * @param User        $user
     * @param FormRequest $request
     *
     * @return void
     */
    public static function sendSignEmail(User $user, FormRequest $request)
    {
        $ip = $request->getClientIp();
        $currentDateTime = date(DATE_RFC822);
        Mail::to($user->email)->send(new LoginMail($currentDateTime, $ip, $user->name));
    }
}
