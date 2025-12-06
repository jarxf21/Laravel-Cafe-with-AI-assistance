<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Order;

class MyOrdersPage extends Component
{
    #[Title('My Orders - Cafe AI')]
    public function render()
    {
        $orders = Order::where('ip_address', request()->ip())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('livewire.my-orders-page', [
            'orders' => $orders,
        ]);
    }
}
