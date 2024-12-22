<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LivewirePatchMiddleware {

    public function handle(Request $request, Closure $next) {
        if($request->method() !== 'GET' && $request->header('Accept') !== 'text/html') {
            return $next($request);
        }

        $response = $next($request);
        if($response->isRedirection() || $response->isNotFound()) {
            return $response;
        }

        // If it's a binary file, we don't want to inject the patch
        if(!str_contains($response->headers->get('Content-Type'), 'text/html')) {
            return $response;
        }

        // Inject patch into response, before closing head tag
        $response->setContent(
            str_replace(
                '</head>',
                '<script>
                    const original = window.history.replaceState;
                    let timer = Date.now();

                    let timeout = null;
                    let lastArgs = null;

                    window.history.replaceState = function (...args) {
                        const time = Date.now();
                        if (time - timer < 300) {
                            lastArgs = args;

                            if (timeout) {
                                clearTimeout(timeout);
                            }

                            timeout = setTimeout(() => {
                                original.apply(this, lastArgs);

                                timeout = null;
                                lastArgs = null;
                            }, 100);

                            return;
                        }

                        timer = time;

                        original.apply(this, args);
                    };
                </script></head>',
                $response->getContent()
            )
        );

        return $response;
    }
}
