<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Account\AccountPage;
use App\Livewire\Auth\EmailVerification;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\PasswordRequest;
use App\Livewire\Auth\PasswordReset;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Checkout\CheckoutPage;
use App\Livewire\Contact\ContactPage;
use App\Livewire\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/contacto', ContactPage::class)->name('contact');
Route::get('/checkout', CheckoutPage::class)->name('checkout');

Route::prefix('auth')->group(function() {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/logout', LogoutController::class)->name('logout');

    Route::prefix('email-verification')->middleware(['auth'])->group(function() {
        Route::get('/resend', EmailVerification::class)->name('verification.resend');
        Route::get('/verify', VerifyEmail::class)->middleware(['signed'])->name('verification.verify');
    });

    Route::prefix('password-reset')->group(function() {
        Route::get('/request', PasswordRequest::class)->name('password.request');
        Route::get('/reset/{token}', PasswordReset::class)->name('password.reset');
    });
});

Route::prefix('/account')->middleware(['auth'])->group(function() {
    Route::get('/', AccountPage::class)->name('account');
});
