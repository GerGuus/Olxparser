<?php

namespace App\Http\Controllers;

use App\Http\Requests\TwoFARequest;
use App\Providers\RouteServiceProvider;
use App\Services\LoginService;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('2fa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TwoFARequest $request)
    {
        LoginService::checkCode($request);

        $request->session()->forget('2fa');

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
