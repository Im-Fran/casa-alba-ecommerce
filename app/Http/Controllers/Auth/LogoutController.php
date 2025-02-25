<?php

namespace App\Http\Controllers\Auth;

class LogoutController {
    public function __invoke() {
        $email = auth()->user()?->email;
        auth()->logout();
        if ($email) {
            session()->put('email', $email);
        }

        return redirect()->route('home');
    }
}
