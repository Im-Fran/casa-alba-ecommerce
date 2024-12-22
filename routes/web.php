<?php

use App\Livewire\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/livewire/livewire.min.js', fn() => response()->file(public_path('../vendor/livewire/livewire/dist/livewire.min.js')));

Route::get('/', HomePage::class)->name('home');
