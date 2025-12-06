<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8" wire:poll.10s>
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
            <a href="{{ route('order') }}" class="text-yellow-600 hover:text-yellow-700 font-semibold">
                &larr; Back to Menu
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-lg">Order #{{ $order->id }}</h3>
                                <p class="text-gray-500 text-sm">Table: {{ $order->table_code }} &bull; {{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold capitalize
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                  ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                  ($order->status === 'ready' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-4">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center py-2">
                                    <div class="flex items-center">
                                        <span class="font-semibold mr-3">{{ $item->quantity }}x</span>
                                        <span class="text-gray-700">{{ $item->product->name }}</span>
                                    </div>
                                    <span class="text-gray-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                            <span class="text-gray-500">Total Amount</span>
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    @if($order->status === 'pending')
                    <div class="bg-yellow-50 px-6 py-3 text-sm text-yellow-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Waiting for cashier confirmation...
                    </div>
                    @elseif($order->status === 'preparing')
                    <div class="bg-blue-50 px-6 py-3 text-sm text-blue-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Barista is preparing your order.
                    </div>
                    @elseif($order->status === 'ready')
                     <div class="bg-green-50 px-6 py-3 text-sm text-green-800 flex items-center font-bold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Order is Ready! Please pick up at the counter.
                    </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No orders yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by placing your first order.</p>
                    <div class="mt-6">
                        <a href="{{ route('order') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            View Menu
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
