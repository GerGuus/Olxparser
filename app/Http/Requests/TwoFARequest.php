<?php

namespace App\Http\Requests;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TwoFARequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            '2fa-code' => ['integer', 'max:6']
        ];
    }

    public function check2FACode(TwoFARequest $request)
    {
        TwoFARequest::checkCode($request);

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
