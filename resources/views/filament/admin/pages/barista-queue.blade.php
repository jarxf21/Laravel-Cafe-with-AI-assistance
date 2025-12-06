<x-filament-panels::page>
    <div wire:poll.5s class="grid grid-cols-1 gap-4 md:grid-cols-3">
        @forelse($orders as $order)
            <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-yellow-500">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Table: {{ $order->table_code }}</h3>
                    <span class="px-2 py-1 text-sm bg-yellow-100 text-yellow-800 rounded">
                        {{ \Carbon\Carbon::parse($order->paid_at)->diffForHumans() }}
                    </span>
                </div>
                
                <div class="space-y-2 mb-6">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-lg">
                            <span>{{ $item->quantity }}x {{ $item->product->name }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t">
                     <x-filament::button
                        size="lg"
                        color="success"
                        wire:click="markReady({{ $order->id }})"
                        class="w-full"
                    >
                        Mark as Ready
                    </x-filament::button>
                </div>
            </div>
        @empty
            <div class="col-span-full flex justify-center items-center p-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500 text-lg">No orders in queue</p>
            </div>
        @endforelse
    </div>
</x-filament-panels::page>
