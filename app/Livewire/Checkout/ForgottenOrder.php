<?php

namespace App\Livewire\Checkout;

use App\Lib\VentiPay;
use Livewire\Attributes\Url;
use Livewire\Component;
use Lunar\Models\Order;
use Usernotnull\Toast\Concerns\WireToast;

class ForgottenOrder extends Component {

    use WireToast;

    #[Url(as: 'order')]
    public Order $order;

    public function boot(): void {
        if($this->order->status === 'cancelled') {
            toast()->danger('El pedido ha sido cancelado. Por favor, realice un nuevo pedido.', 'Pedido Cancelado')->pushOnNextPage();
            $this->redirect(route('home'));
        } else if ($this->order->status === 'payment-received') {
            toast()->success('El pedido ya ha sido pagado. Por favor, revise su correo electrónico para más detalles.', 'Pedido Pagado')->pushOnNextPage();
            $this->redirect(route('home'));
        }
    }

    public function continueCheckout(): void {
        // Check if the order already has a VentiPay checkout ID
        if (!empty($this->order->meta['ventipay_checkout_id'])) {
            try {
                // Get the existing checkout
                $data = app(VentiPay::class)->getCheckout(id: $this->order->meta['ventipay_checkout_id']);
                redirect()->away($data['url']);
            } catch (\Exception) {
                $this->createNewCheckout();
            }
        } else {
            $this->createNewCheckout();
        }
    }

    private function createNewCheckout(): void {
        try {
            $checkoutUrl = app(VentiPay::class)
                ->createCheckout($this->order);
            redirect()->away($checkoutUrl);
        } catch (\Exception) {
            toast()->danger('No se pudo crear el checkout. Por favor, inténtelo de nuevo.', 'Error al Conectar')->push();
        }
    }

    public function cancelOrder(): void {
        // Mark the order as canceled
        $this->order->status = 'cancelled';
        $this->order->save();

        toast()->success('Pedido cancelado correctamente.', '¡Cancelado!')->push();
        $this->redirect(route('home'));
    }
}
