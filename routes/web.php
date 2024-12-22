<?php

use App\Livewire\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/livewire/livewire.min.js', function() {
    $file = '../vendor/livewire/livewire/dist/livewire.min.js';
    if(file_exists($file)) {
        return response(file_get_contents($file))
            ->header('Content-Type', 'application/javascript');
    }

    return response('Livewire not found', 404);
});

Route::get('/', HomePage::class)->name('home');
