<?php

namespace App\Http\Middleware\Webhooks;

use Closure;
use Illuminate\Http\Request;

class VentiSignatureValidatorMiddleware {

    public function handle(Request $request, Closure $next) {
        // Validate signature
        if(!$request->hasHeader('venti-signature')) {
            return response()->json([
                'error' => 'Missing Signature Header!'
            ]);
        }

        // Sample header: 't=unixtimestamp,v1=hmac-sha256hash'
        $webhookSecret = config('services.ventipay.webhook_secret');
        $header = explode(',', $request->header('venti-signature'));
        $signature = null;
        $unixTimestamp = null;
        foreach($header as $h) {
            if(str_starts_with($h, 't=')) {
                $unixTimestamp = substr($h, 2);
            } else if(str_starts_with($h, 'v1=')) {
                $signature = substr($h, 3);
            }
        }

        if($signature == null || $unixTimestamp == null) {
            return response()->json([
                'error' => 'Invalid Signature Header!'
            ]);
        }

        // If timestamp is older than 5 minutes, reject the request
        $currentTimestamp = time();
        if($currentTimestamp - $unixTimestamp > 300) { // Tolerance of 5 minutes as recommended by VentiPay
            return response()->json([
                'error' => 'Request expired!'
            ]);
        }

        // Verification string: <timestamp>.<payload>
        $string = "{$unixTimestamp}.{$request->getContent()}";
        $hash = hash_hmac('sha256', $string, $webhookSecret);
        if(!hash_equals($signature, $hash)) {
            return response()->json([
                'error' => 'Invalid Signature!',
            ]);
        }

        return $next($request);
    }
}
