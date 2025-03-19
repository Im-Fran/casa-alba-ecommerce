<?php

namespace App\Livewire\Account;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersPage extends Component {

    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function orders(): LengthAwarePaginator {
        return auth()->user()->orders()->latest('created_at')->paginate(10);
    }

    public function render(): View {
        return view('livewire.account.orders-page', [
            'orders' => $this->orders(),
        ]);
    }
}
