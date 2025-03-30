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
        $webhookSecret = config('services.ventipay.secret');
        $header = explode(',', $request->header('venti-signature'));
        $signature = null;
        $timestamp = null;
        foreach($header as $h) {
            if(str_starts_with($h, 't=')) {
                $timestamp = substr($h, 2);
            } else if(str_starts_with($h, 'v1=')) {
                $signature = substr($h, 3);
            }
        }

        if($signature == null || $timestamp == null) {
            return response()->json([
                'error' => 'Invalid Signature Header!'
            ]);
        }

        // Verification string: <timestamp>.<payload>
        $hash = hash_hmac('sha256', "$timestamp.{$request->getContent()}", $webhookSecret);
        if(!hash_equals($signature, $hash)) {
            return response()->json([
                'error' => 'Invalid Signature!'
            ]);
        }

        return $next($request);
    }
}
