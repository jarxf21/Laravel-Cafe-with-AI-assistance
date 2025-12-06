<div class="min-h-screen bg-gray-50 flex flex-col md:flex-row" x-data="{ 
    cartOpen: false,
    init() {
        if(window.innerWidth >= 768) this.cartOpen = true;
    }
}">
    <!-- Mobile Cart Toggle -->
    <div class="md:hidden fixed bottom-4 right-4 z-50">
        <button @click="cartOpen = !cartOpen" class="bg-yellow-500 text-black p-4 rounded-full shadow-lg relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            @if(count($cart) > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ array_sum(array_column($cart, 'quantity')) }}</span>
            @endif
        </button>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-4 md:p-8 overflow-y-auto h-screen">
        <h1 class="text-3xl font-bold mb-6">Menu</h1>

        <!-- Categories -->
        <div class="flex space-x-4 mb-8 overflow-x-auto pb-2 scrollbar-hide">
            <button 
                wire:click="setCategory('all')" 
                class="px-6 py-2 rounded-full whitespace-nowrap transition {{ $activeCategory === 'all' ? 'bg-black text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                All
            </button>
            @foreach($categories as $category)
            <button 
                wire:click="setCategory('{{ $category->slug }}')" 
                class="px-6 py-2 rounded-full whitespace-nowrap transition {{ $activeCategory === $category->slug ? 'bg-black text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                {{ $category->name }}
            </button>
            @endforeach
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition">
                <div class="h-40 rounded-xl overflow-hidden mb-4 relative bg-gray-100">
                     @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-400">
                             <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                    <span class="text-yellow-600 font-bold">Rp {{ number_format($product->price/1000, 0) }}k</span>
                </div>
                <p class="text-gray-500 text-sm mb-4 line-clamp-2 h-10">{{ $product->description }}</p>
                <button wire:click="addToCart({{ $product->id }})" class="w-full py-2 bg-gray-100 text-gray-800 rounded-xl font-semibold hover:bg-yellow-400 hover:text-black transition">
                    Add to Cart
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div 
        x-show="cartOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-full opacity-0"
        class="w-full md:w-96 bg-white shadow-2xl h-screen fixed top-0 right-0 md:relative md:block z-40 flex flex-col"
    >
        <div class="p-6 flex-1 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Current Order</h2>
                <button @click="cartOpen = false" class="md:hidden text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Cart Items -->
            @if(count($cart) > 0)
                <div class="space-y-4">
                    @foreach($cart as $index => $item)
                    <div class="flex items-center gap-4 animate-fade-in-up">
                        <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                             @if($item['image'])
                                <img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-cover">
                             @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800">{{ $item['name'] }}</h4>
                            <p class="text-sm text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                             <button wire:click="updateQuantity({{ $index }}, -1)" class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">-</button>
                             <span class="font-semibold w-4 text-center">{{ $item['quantity'] }}</span>
                             <button wire:click="updateQuantity({{ $index }}, 1)" class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center hover:bg-gray-800">+</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p>Your cart is empty</p>
                </div>
            @endif
        </div>

        <!-- Checkout Section -->
        @if(count($cart) > 0)
        <div class="p-6 border-t bg-gray-50">
            <div class="flex justify-between mb-4 text-lg font-bold">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            
            <div class="space-y-3 mb-6">
                <input type="text" wire:model.defer="customerName" placeholder="Your Name" class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <input type="text" wire:model.defer="tableCode" placeholder="Table Number/Code" class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                @error('customerName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('tableCode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button 
                wire:click="checkout" 
                wire:loading.attr="disabled"
                class="w-full py-4 bg-black text-white font-bold rounded-xl hover:bg-gray-800 transition transform active:scale-95 disabled:opacity-50 flex justify-center items-center gap-2"
            >
                <span wire:loading.remove>Place Order</span>
                <span wire:loading>Processing...</span>
            </button>
        </div>
        @endif
    </div>

    <!-- Notification Toast -->
    <div 
        x-data="{ show: false, message: '', type: 'success' }" 
        x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition.duration.300ms
        class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-full shadow-lg text-white font-semibold"
        :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
        style="display: none;"
    >
        <span x-text="message"></span>
    </div>
</div>
