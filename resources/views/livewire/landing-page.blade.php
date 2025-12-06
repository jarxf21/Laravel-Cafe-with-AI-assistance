<div class="flex flex-col min-h-screen">
    <!-- Hero Section -->
    <section class="relative bg-gray-900 text-white overflow-hidden h-[600px] flex items-center">
        <div class="absolute inset-0 z-0">
             <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Coffee Background" class="w-full h-full object-cover opacity-40">
             <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-2xl">
                <span class="text-yellow-400 font-semibold tracking-wider uppercase mb-2 block animate-fade-in-up">Welcome to Cafe AI</span>
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight animate-fade-in-up delay-100">
                    Experience the <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">Future of Coffee</span>
                </h1>
                <p class="text-xl text-gray-300 mb-8 animate-fade-in-up delay-200">
                    Order seamlessly, track in real-time, and let our AI Barista guide your perfect choice.
                </p>
                <div class="flex gap-4 animate-fade-in-up delay-300">
                    <a href="{{ route('order') }}" class="px-8 py-4 bg-yellow-500 text-black font-bold rounded-full hover:bg-yellow-400 transition transform hover:scale-105 shadow-lg shadow-yellow-500/30">
                        Order Now
                    </a>
                    <a href="#featured" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-black transition transform hover:scale-105">
                        View Menu
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-12 text-center">
                <div class="p-8 rounded-2xl bg-gray-50 hover:shadow-xl transition duration-300 border border-gray-100">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6 text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Fast Ordering</h3>
                    <p class="text-gray-600">Scan QR, order instantly from your phone. No waiting in line.</p>
                </div>
                <div class="p-8 rounded-2xl bg-gray-50 hover:shadow-xl transition duration-300 border border-gray-100">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">AI Assistant</h3>
                    <p class="text-gray-600">Our AI Barista recommends drinks based on your mood and taste.</p>
                </div>
                <div class="p-8 rounded-2xl bg-gray-50 hover:shadow-xl transition duration-300 border border-gray-100">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Real-time Tracking</h3>
                    <p class="text-gray-600">Watch your coffee being prepared and know exactly when it's ready.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-yellow-600 font-semibold tracking-wider uppercase">Our Favorites</span>
                <h2 class="text-4xl font-bold mt-2">Popular Choices</h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($featuredProducts as $product)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                    <div class="h-64 overflow-hidden relative group">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition duration-300"></div>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                            </div>
                            <span class="text-xl font-bold text-yellow-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-gray-600 mb-6 text-sm line-clamp-2">{{ $product->description }}</p>
                        <a href="{{ route('order') }}" class="block w-full text-center py-3 border-2 border-gray-900 text-gray-900 font-bold rounded-xl hover:bg-gray-900 hover:text-white transition duration-300">
                            Pre-order
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('order') }}" class="inline-flex items-center text-yellow-600 font-bold hover:text-yellow-700 transition">
                    View Full Menu
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-2xl font-bold mb-4">Cafe AI</h3>
            <p class="text-gray-400 mb-8">Brewing the future, one cup at a time.</p>
            <div class="text-gray-600 text-sm">
                &copy; {{ date('Y') }} Cafe AI Assistance. All rights reserved.
            </div>
        </div>
    </footer>
</div>
