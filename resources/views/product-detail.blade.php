<div class="max-w-7xl mx-auto bg-white p-6 lg:p-12 font-sans text-gray-900" x-data="{ 
    mainImage: '{{ $product->image }}',
    qty: 1,
    isWishlisted: {{ $isWishlisted ? 'true' : 'false' }},
    wishlistLoading: false,
    isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},
    loginUrl: '{{ route("login") }}',
    wishlistUrl: '{{ route("wishlist.toggle") }}',
    csrfToken: '{{ csrf_token() }}',
    productId: {{ $product->id }},
    toggleWishlist() {
        if (!this.isLoggedIn) {
            window.location.href = this.loginUrl;
            return;
        }
        if (this.wishlistLoading) {
            return;
        }
        this.wishlistLoading = true;

        fetch(this.wishlistUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: this.productId })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Server responded with an error.');
            }
            return res.json();
        })
        .then(data => {
            this.isWishlisted = (data.status === 'added');
        })
        .catch(error => {
            console.error('Wishlist toggle failed:', error);
            alert('An error occurred while updating your wishlist. Please try again.');
        })
        .finally(() => {
            this.wishlistLoading = false;
        });
    },
    formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }
}">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16">
        
        <!-- Left Column: Gallery Section (5 Cols) -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            <!-- Main Image Area -->
            <div class="relative w-full aspect-[4/5] bg-gray-50 rounded-xl overflow-hidden flex items-center justify-center border border-gray-100 group">
                
                <!-- Discount Badge -->
                <div class="absolute top-6 left-6 bg-[#0a2351] text-white w-24 h-24 rounded-full flex flex-col items-center justify-center shadow-xl z-10">
                    <span class="text-2xl font-bold leading-none">70%</span>
                    <span class="text-[10px] uppercase font-medium tracking-wider mt-1">Discount</span>
                </div>
                
                <!-- Placeholder Product Image -->
                <img :src="mainImage" 
                     alt="{{ $product->name }}" 
                     class="w-3/4 h-3/4 object-contain mix-blend-multiply group-hover:scale-105 transition duration-500">
            </div>

            <!-- Thumbnails Row -->
            <div class="grid grid-cols-4 gap-4">
                <div @click="mainImage = '{{ $product->image }}'" class="aspect-square bg-gray-50 rounded-lg border border-gray-200 hover:border-[#0e4b44] cursor-pointer flex items-center justify-center transition-all duration-300">
                    <img src="{{ $product->image }}" class="w-1/2 h-1/2 object-contain opacity-60 hover:opacity-100 transition-opacity">
                </div>
                <!-- Dummy Thumbnails (Using same image for demo) -->
                <div @click="mainImage = 'https://cdn-icons-png.flaticon.com/512/2909/2909787.png'" class="aspect-square bg-gray-50 rounded-lg border border-gray-200 hover:border-[#0e4b44] cursor-pointer flex items-center justify-center transition-all duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/2909/2909787.png" class="w-1/2 h-1/2 object-contain opacity-60 hover:opacity-100 transition-opacity">
                </div>
                <div @click="mainImage = 'https://cdn-icons-png.flaticon.com/512/2909/2909841.png'" class="aspect-square bg-gray-50 rounded-lg border border-gray-200 hover:border-[#0e4b44] cursor-pointer flex items-center justify-center transition-all duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/2909/2909841.png" class="w-1/2 h-1/2 object-contain opacity-60 hover:opacity-100 transition-opacity">
                </div>
                <div @click="mainImage = 'https://cdn-icons-png.flaticon.com/512/2909/2909832.png'" class="aspect-square bg-gray-50 rounded-lg border border-gray-200 hover:border-[#0e4b44] cursor-pointer flex items-center justify-center transition-all duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/2909/2909832.png" class="w-1/2 h-1/2 object-contain opacity-60 hover:opacity-100 transition-opacity">
                </div>
            </div>
        </div>

        <!-- Right Column: Product Information (7 Cols) -->
        <div class="lg:col-span-7 flex flex-col">

            <!-- Header -->
            <div class="mb-5">
                <p class="text-sm text-gray-500 font-bold uppercase tracking-wide mb-2">{{ $product->type }}</p>
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>
            </div>

            <!-- Rating -->
            <div class="flex items-center gap-4 mb-8 border-b border-gray-100 pb-8">
                <div class="flex items-center text-yellow-400 text-sm gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($avgRating))
                            <i class="fa-solid fa-star"></i>
                        @else
                            <i class="fa-regular fa-star text-gray-300"></i>
                        @endif
                    @endfor
                </div>
                <span class="font-bold text-sm text-gray-700">{{ number_format($avgRating, 1) }} Rating</span>
                <span class="text-gray-300">|</span>
                <a href="#reviews-section" class="text-sm text-gray-500 underline hover:text-[#0e4b44] transition">({{ $reviewCount }} reviews)</a>
            </div>

            <!-- Price -->
            <div class="mb-8">
                <div class="flex items-start">
                    <span class="text-5xl font-bold text-gray-900 tracking-tighter" x-text="formatRupiah({{ $product->price }})"></span>
                </div>
                <p class="text-sm text-gray-400 mt-2">Inclusive of all taxes. Weight: {{ $product->weight }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mb-8">
                <!-- Quantity Selector -->
                <div class="flex items-center border border-gray-300 rounded-full h-full">
                    <button @click="qty > 1 ? qty-- : qty" class="px-5 py-4 text-gray-600 hover:text-[#0e4b44] transition font-bold">-</button>
                    <span x-text="qty" class="font-bold text-gray-900 w-8 text-center"></span>
                    <button @click="qty++" class="px-5 py-4 text-gray-600 hover:text-[#0e4b44] transition font-bold">+</button>
                </div>

                <button x-data="{ loading: false, added: false }" 
                        @click="loading = true; $dispatch('add-to-cart', { id: {{ $product->id }}, qty: qty }); setTimeout(() => { loading = false; added = true; setTimeout(() => added = false, 2000) }, 500)" 
                        class="flex-1 py-4 px-8 rounded-full border-2 border-[#0e4b44] text-[#0e4b44] font-bold uppercase tracking-wider hover:bg-[#0e4b44] hover:text-white transition-all duration-300 flex items-center justify-center gap-3 group">
                    <i class="fa-solid" :class="added ? 'fa-check' : (loading ? 'fa-spinner fa-spin' : 'fa-basket-shopping group-hover:animate-bounce')"></i> 
                    <span x-text="added ? 'Added to Bucket' : (loading ? 'Adding...' : 'Add to bucket')"></span>
                </button>
            </div>

            <!-- Secondary Actions -->
            <div class="flex flex-wrap items-center gap-6 text-xs font-bold text-gray-500 mb-10">
                <button @click="toggleWishlist()" :disabled="wishlistLoading" class="flex items-center gap-2 hover:text-[#0e4b44] transition-colors uppercase tracking-wide group" :class="{'cursor-not-allowed': wishlistLoading}">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center group-hover:bg-[#0e4b44] group-hover:text-white transition"
                         :class="wishlistLoading ? 'bg-gray-200' : (isWishlisted ? 'bg-red-50 text-red-500' : 'bg-gray-100')">
                        <i :class="wishlistLoading ? 'fa-solid fa-spinner fa-spin text-gray-500' : (isWishlisted ? 'fa-solid fa-heart' : 'fa-regular fa-heart')"></i>
                    </div>
                    <span x-text="wishlistLoading ? 'Updating...' : (isWishlisted ? 'Wishlisted' : 'Add to wishlist')"></span>
                </button>
            </div>

            <!-- Social Proof -->
            <div class="flex items-center gap-3 bg-orange-50 text-orange-800 px-5 py-4 rounded-xl mb-8 w-fit border border-orange-100 shadow-sm">
                <div class="bg-white p-1.5 rounded-full shadow-sm">
                    <i class="fa-solid fa-fire text-orange-500"></i>
                </div>
                <span class="text-sm font-bold">100 sold in last 35 hour</span>
            </div>

            <!-- Footer Info -->
            <div class="mt-auto border-t border-gray-100 pt-8 space-y-3 text-sm text-gray-600">
                <p class="flex items-center"><span class="font-bold text-gray-900 w-28">SKU:</span> <span class="font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-700">GR-{{ $product->id }}882</span></p>
                <p class="flex items-center"><span class="font-bold text-gray-900 w-28">Categories:</span> <span class="text-[#0e4b44] font-medium hover:underline cursor-pointer">{{ $product->type }}</span></p>
                <p class="pt-4 leading-relaxed text-gray-500 max-w-2xl">
                    Experience the finest quality {{ strtolower($product->name) }} sourced directly from organic farms. Perfect for healthy meals for your family. 100% natural and preservative-free.
                </p>
            </div>

        </div>
    </div>

    <!-- Reviews Section -->
    <div id="reviews-section" class="mt-16 border-t border-gray-100 pt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Customer Reviews ({{ $reviewCount }})</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Review List -->
            <div class="space-y-8">
                @forelse($reviews as $review)
                <div class="flex gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random" class="w-10 h-10 rounded-full">
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</h4>
                        <div class="flex text-yellow-400 text-xs my-1">
                            @for($i=1; $i<=5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular text-gray-300' }} fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 italic">No reviews yet. Be the first to review!</p>
                @endforelse
            </div>

            <!-- Review Form -->
            <div class="bg-gray-50 p-8 rounded-2xl h-fit">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <h3 class="font-bold text-lg text-gray-900 mb-4">Write a Review</h3>
                @auth
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="mb-4" x-data="{ rating: {{ old('rating', 5) }}, hoverRating: 0 }">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Rating</label>
                        <div class="flex gap-1 cursor-pointer" @mouseleave="hoverRating = 0">
                            <template x-for="i in 5">
                                <i @click="rating = i" 
                                   @mouseover="hoverRating = i"
                                   class="fa-star text-xl transition"
                                   :class="(hoverRating || rating) >= i ? 'fa-solid text-yellow-400' : 'fa-regular text-gray-300'"></i>
                            </template>
                        </div>
                        <input type="hidden" name="rating" x-model="rating">
                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Your Review</label>
                        <textarea name="comment" rows="4" class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#0e4b44] focus:border-transparent" placeholder="How was the product?">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-[#0e4b44] text-white font-bold py-3 rounded-xl hover:bg-opacity-90 transition">Submit Review</button>
                </form>
                @else
                <p class="text-gray-600 text-sm">Please <a href="{{ route('login') }}" class="text-[#0e4b44] font-bold hover:underline">login</a> to write a review.</p>
                @endauth
            </div>
        </div>
    </div>
</div>
