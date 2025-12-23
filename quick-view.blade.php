<div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
    <!-- Product Image -->
    <div class="product-image flex items-center justify-center bg-gray-100 rounded-lg">
        <img src="{{ $product->image_url ?? 'https://via.placeholder.com/400' }}" 
             alt="{{ $product->name }}" 
             class="max-h-80 object-contain rounded-lg shadow-sm">
    </div>

    <!-- Product Details -->
    <div class="product-details flex flex-col justify-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>
        
        <div class="text-xl font-semibold text-indigo-600 mb-4">
            {{ number_format($product->price, 2) }}
        </div>

        <p class="text-gray-600 mb-6 leading-relaxed">
            {{ $product->description ?? 'No description available.' }}
        </p>

        <!-- Add to Cart Form -->
        <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="mt-auto">
            @csrf
            <div class="flex items-center gap-4">
                <input type="number" name="quantity" value="1" min="1" 
                       class="w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center">
                
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-2.5 rounded-md hover:bg-indigo-700 transition-colors font-medium shadow-sm">
                    Add to Cart
                </button>
            </div>
        </form>
    </div>
</div>
