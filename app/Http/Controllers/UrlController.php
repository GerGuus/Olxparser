<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('url');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Url::create($request->all());

        return redirect()->route('url.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Url $url): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Url $url): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url): RedirectResponse
    {
        //
    }
}
