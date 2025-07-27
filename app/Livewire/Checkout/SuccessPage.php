<?php

namespace App\Livewire\Checkout;

use App\Lib\VentiPay;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Order;
use Usernotnull\Toast\Concerns\WireToast;
use function Sentry\captureException;

class SuccessPage extends Component {

    use WireToast;

    #[Locked]
    #[Url]
    public string $status;

    #[Locked]
    #[Url]
    public int $external_reference;

    public Order $order;

    public function mount(): void {
        // From here we know the order was successful, so we can forget the session, later the webhook will be in charge of notifying and adding transactions.
        CartSession::forget();

        $this->order = Order::with(['customer', 'billingAddress', 'shippingAddress'])->find($this->external_reference);
    }
}
