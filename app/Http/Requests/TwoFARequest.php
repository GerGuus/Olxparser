<?php

namespace App\Http\Requests;

use App\Http\Requests\Auth\LoginRequest;

class TwoFARequest extends LoginRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|\Illuminate\Contracts\Validation\Rule|string>
     */
    public function rules(): array
    {
        return [
            '2fa-code' => ['integer', 'max:6'],
        ];
    }
}
