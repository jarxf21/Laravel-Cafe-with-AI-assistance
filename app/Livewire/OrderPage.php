<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class OrderPage extends Component
{
    #[Title('Order - Cafe AI')]
    public $activeCategory = 'all';
    public $cart = [];
    public $total = 0;
    public $customerName = '';
    public $tableCode = '';
    
    // Anti-spam
    public $processing = false;

    public function mount()
    {
        // Try to recover table code from session if exists
        $this->tableCode = session('table_code', '');
        $this->cart = session('cart', []);
        $this->calculateTotal();
    }

    #[On('restore-cart')]
    public function restoreCart($cartData)
    {
        if (empty($this->cart) && !empty($cartData)) {
            $this->cart = $cartData;
            $this->calculateTotal();
            session(['cart' => $this->cart]);
        }
    }

    public function setCategory($slug)
    {
        $this->activeCategory = $slug;
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        
        if (!$product || !$product->is_available || $product->stock <= 0) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Product unavailable.']);
            return;
        }

        $index = $this->findInCart($productId);

        if ($index !== false) {
            // Check stock for increment
            if ($product->stock > $this->cart[$index]['quantity']) {
                $this->cart[$index]['quantity']++;
            } else {
                 $this->dispatch('notify', ['type' => 'error', 'message' => 'Not enough stock.']);
                 return;
            }
        } else {
            $this->cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        $this->calculateTotal();
        $this->updateSession();
        $this->dispatch('cart-updated', $this->cart);
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Added to cart.']);
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        $this->calculateTotal();
        $this->updateSession();
        $this->dispatch('cart-updated', $this->cart);
    }
    
    public function updateQuantity($index, $change)
    {
        if (!isset($this->cart[$index])) return;
        
        $newQty = $this->cart[$index]['quantity'] + $change;
        
        if ($newQty <= 0) {
            $this->removeFromCart($index);
            return;
        }
        
        // Stock check
        $product = Product::find($this->cart[$index]['product_id']);
        if ($product->stock < $newQty) {
             $this->dispatch('notify', ['type' => 'error', 'message' => 'Not enough stock.']);
             return;
        }
        
        $this->cart[$index]['quantity'] = $newQty;
        $this->calculateTotal();
        $this->updateSession();
        $this->dispatch('cart-updated', $this->cart);
    }

    public function calculateTotal()
    {
        $this->total = array_reduce($this->cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
    }

    private function findInCart($productId)
    {
        foreach ($this->cart as $key => $item) {
            if ($item['product_id'] == $productId) return $key;
        }
        return false;
    }

    private function updateSession()
    {
        session(['cart' => $this->cart]);
        if ($this->tableCode) session(['table_code' => $this->tableCode]);
    }

    public function checkout()
    {
        $this->validate([
            'customerName' => 'required|min:2',
            'tableCode' => 'required', 
            'cart' => 'required|min:1',
        ]);

        if ($this->processing) return;
        $this->processing = true;

        // Anti-ghost: Check pending orders limit
        $pendingCount = Order::where('ip_address', request()->ip())
            ->where('status', 'pending')
            ->count();
            
        if ($pendingCount >= 1) { 
             $this->dispatch('notify', ['type' => 'error', 'message' => 'You have a pending order tailored for you. Please wait.']);
             $this->processing = false;
             return;
        }

        // Create Order
        $order = Order::create([
            'table_code' => $this->tableCode,
            'customer_name' => $this->customerName,
            'total_amount' => $this->total,
            'status' => 'pending',
            'payment_method' => 'cash', // Default
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
            
            // Decrement Stock
            Product::find($item['product_id'])->decrement('stock', $item['quantity']);
        }

        // Clear Cart
        $this->cart = [];
        $this->calculateTotal();
        session()->forget('cart');
        $this->dispatch('cart-updated', []);
        
        $this->processing = false;
        
        // Redirect or Notify
        return redirect()->route('my-orders')->with('success', 'Order placed successfully!');
    }

    public function render()
    {
        $query = Product::where('is_available', true)->where('stock', '>', 0);
        
        if ($this->activeCategory !== 'all') {
            $query->whereHas('category', function($q) {
                $q->where('slug', $this->activeCategory);
            });
        }

        return view('livewire.order-page', [
            'products' => $query->get(),
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }
}
