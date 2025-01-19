<?php

use App\Livewire\Checkout\CheckoutPage;
use App\Livewire\Contact\ContactPage;
use App\Livewire\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/contacto', ContactPage::class)->name('contact');
Route::get('/checkout', CheckoutPage::class)->name('checkout');
