<?php

namespace App\Rules;

use App\Helpers\TurnstileClient;
use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;

class TurnstileRule implements ValidationRule {

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        try {
            $response = app(TurnstileClient::class)->siteVerify($value);

            if($response['success']) {
                return;
            }

            switch ($response['error-codes']) {
                case 'missing-input-secret':
                case 'missing-input-response':
                case 'invalid-input-secret':
                case 'invalid-input-response': $fail('El captcha no se ha configurado correctamente. Por favor intenta más tarde.');break;
                case 'bad-request':
                case 'timeout-or-duplicate':
                case 'internal-error': $fail('Ocurrió un error al intentar validar el captcha. Por favor intenta más tarde.');break;
                default: $fail('Ocurrió un error inesperado al intentar validar el captcha. Por favor intenta más tarde.');break;
            }
        } catch (Exception) {
            $fail('Ocurrió un error al intentar validar el captcha. Por favor intenta más tarde.');
        }
    }
}
