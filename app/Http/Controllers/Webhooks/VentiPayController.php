<?php

namespace App\Http\Controllers\Webhooks;

use App\Lib\VentiPayWebhookActions\WebhookActions;
use Illuminate\Http\Request;

class VentiPayController {

    public function __invoke(Request $request) {
        $type = $request->type;
        $action = WebhookActions::$actions[$type];
        if(!isset($action)) {
            return response()->json([
                'error' => 'Invalid webhook type'
            ]);
        }

        $action = new $action;
        return $action->handle($request);
    }
}
