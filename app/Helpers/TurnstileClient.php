<?php

namespace App\Helpers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class TurnstileClient {

    public function __construct(
        protected string $secret,
    ) {}

    /**
     * @throws ConnectionException
     */
    public function siteVerify($response): array {
        $response = Http::retry(3, 100)
            ->asForm()
            ->acceptJson()
            ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $this->secret,
                'response' => $response
            ]);

        if(!$response->ok()) {
            return [
                'success' => false,
                'error-codes' => []
            ];
        }

        return [
            'success' => $response->json('success'),
            'error-codes' => $response->json('error-codes')
        ];
    }

}
