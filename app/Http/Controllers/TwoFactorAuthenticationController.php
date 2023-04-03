<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use Couchbase\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function store(Request $request): RedirectResponse
    {
        LoginService::checkCode($request);
    }

}
