<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TwoFactorAuthenticationController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->code === session()->get('2fa')) {

        }
    }
}
