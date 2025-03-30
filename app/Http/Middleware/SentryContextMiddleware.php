<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentry\State\Scope;
use function Sentry\configureScope;

class SentryContextMiddleware {
    public function handle(Request $request, Closure $next) {
        if(auth()->check() && app()->bound('sentry')) {
            configureScope(function(Scope $scope): void {
                $scope->setUser([
                    'id' => auth()->id(),
                    'email' => auth()->user()->email,
                ]);
            });
        }

        return $next($request);
    }
}
