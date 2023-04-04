<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlUpdateRequest;
use App\Models\Url;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urlList = Url::where('user_id', Auth::user()->id)->get();

        return view('url-list', ['list' => $urlList]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('url');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlUpdateRequest $request): RedirectResponse
    {
        Url::create($request->all() + ['user_id' => Auth::user()->id]);

        return redirect()->route('url.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Url $url)
    {
        return view('url-edit', ['url' => $url]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Url $url): RedirectResponse
    {
        $url->url = $request->url;

        $url->save();

        return redirect()->route('url.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url): RedirectResponse
    {
        //        Url::where('id', $url->id)->delete();
        Url::destroy($url->id);
        return redirect()->route('url.index');
    }
}
