<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
    <!-- Chat Window -->
    <div 
        x-data="{ scrollBottom() { $refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight } }"
        x-init="$watch('$wire.isOpen', value => { if(value) setTimeout(() => scrollBottom(), 100) })"
        x-show="$wire.isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="bg-white w-80 md:w-96 rounded-2xl shadow-2xl overflow-hidden mb-4 border border-gray-200 flex flex-col h-[500px]"
    >
        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center text-black font-bold">
                    AI
                </div>
                <div>
                    <h3 class="font-bold">AI Barista</h3>
                    <p class="text-xs text-gray-300">Always here to help</p>
                </div>
            </div>
            <button wire:click="toggle" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" x-ref="chatContainer">
            @foreach($messages as $msg)
                <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[80%] p-3 rounded-2xl text-sm 
                        {{ $msg['role'] === 'user' ? 'bg-yellow-500 text-black rounded-tr-none' : 'bg-white border border-gray-200 text-gray-800 rounded-tl-none shadow-sm' }}">
                        {{ $msg['content'] }}
                    </div>
                </div>
            @endforeach
            @if($isTyping)
                <div class="flex justify-start">
                    <div class="bg-white border border-gray-200 p-3 rounded-2xl rounded-tl-none shadow-sm flex gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce delay-100"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce delay-200"></span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Input -->
        <div class="p-4 bg-white border-t border-gray-100">
            <form wire:submit.prevent="sendMessage">
                <div class="relative">
                    <input 
                        wire:model="input" 
                        type="text" 
                        placeholder="Ask about our coffee..." 
                        class="w-full pl-4 pr-12 py-3 rounded-full border border-gray-300 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 text-sm"
                    >
                    <button 
                        type="submit" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-gray-800 transition disabled:opacity-50"
                        wire:loading.attr="disabled"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toggle Button -->
    <button 
        wire:click="toggle"
        class="w-16 h-16 bg-black text-yellow-500 rounded-full shadow-lg hover:scale-110 transition transform flex items-center justify-center group"
    >
        <span class="absolute -top-2 -right-2 w-4 h-4 bg-red-500 rounded-full animate-ping"></span>
        <svg x-show="!$wire.isOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        <svg x-show="$wire.isOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
