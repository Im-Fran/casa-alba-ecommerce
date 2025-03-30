<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Webhooks\VentiPayController;
use App\Http\Middleware\Webhooks\VentiSignatureValidatorMiddleware;
use App\Livewire\Account\AccountPage;
use App\Livewire\Account\AddressesPage;
use App\Livewire\Account\OrdersPage;
use App\Livewire\Account\SecurityPage;
use App\Livewire\Auth\EmailVerification;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\PasswordRequest;
use App\Livewire\Auth\PasswordReset;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Checkout\CancelPage;
use App\Livewire\Checkout\CheckoutPage;
use App\Livewire\Checkout\OrderPreviewPage;
use App\Livewire\Checkout\SuccessPage;
use App\Livewire\Contact\ContactPage;
use App\Livewire\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/contacto', ContactPage::class)->name('contact');

Route::prefix('/checkout')->group(function(){
    Route::get('/', CheckoutPage::class)->name('checkout');
    Route::get('/success/{order}', SuccessPage::class)->middleware(['signed'])->name('checkout.success');
    Route::get('/cancel/{order}', CancelPage::class)->middleware(['signed'])->name('checkout.cancel');
});

Route::prefix('auth')->group(function() {
    Route::get('/login', LoginPage::class)->middleware(['guest'])->name('login');
    Route::get('/register', RegisterPage::class)->middleware(['guest'])->name('register');
    Route::get('/logout', LogoutController::class)->middleware(['auth'])->name('logout');

    Route::prefix('email-verification')->middleware(['auth'])->group(function() {
        Route::get('/resend', EmailVerification::class)->name('verification.notice');
        Route::get('/verify', VerifyEmail::class)->middleware(['signed'])->name('verification.verify');
    });

    Route::prefix('password-reset')->group(function() {
        Route::get('/request', PasswordRequest::class)->name('password.request');
        Route::get('/reset', PasswordReset::class)->name('password.reset');
    })->middleware(['guest']);
});

Route::prefix('/account')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', AccountPage::class)->name('account');
    Route::get('/security', SecurityPage::class)->name('account.security');
    Route::get('/addresses', AddressesPage::class)->name('account.addresses');
    Route::get('/orders', OrdersPage::class)->name('account.orders');
    Route::get('/orders/{order}', OrderPreviewPage::class)->name('account.orders.view');
});


Route::post('/webhooks/ventipay', VentiPayController::class)->middleware([VentiSignatureValidatorMiddleware::class])->name('webhooks.ventipay');

Route::prefix('/r')->group(function() {
    Route::get('/tiktok', fn () => redirect()->away('https://www.tiktok.com/@productoscasaalba', 301))->name('redirect.tiktok');
    Route::get('/instagram', fn () => redirect()->away('https://www.instagram.com/productoscasaalba', 301))->name('redirect.instagram');
});
