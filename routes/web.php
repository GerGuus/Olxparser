<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFactorAuthenticationController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('url', UrlController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('2fa')->group(function () {
    Route::get('2fa-check', [TwoFactorAuthenticationController::class, 'index'])
        ->name('2fa-check.index');
    Route::post('2fa-check', [TwoFactorAuthenticationController::class, 'store'])
        ->name('2fa-check.store');
});

require __DIR__ . '/auth.php';
