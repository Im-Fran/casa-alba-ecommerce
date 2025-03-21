<?php

namespace App\Lib\VentiPayWebhookActions;

use Illuminate\Http\Request;

abstract class WebhookAction {

    public abstract function handle(Request $request): \Illuminate\Http\Response;

}
