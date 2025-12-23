<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ruble Retails - Desktop Store</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="manifest" href="/manifest.json">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ruble: {
                            dark: '#0f393b',
                            main: '#14b8a6',
                            light: '#ccfbf1',
                            accent: '#facc15',
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800"
      x-data="{ 
          cartOpen: false,
          quickViewOpen: false,
          selectedProduct: null,
          installPrompt: null,
          searchQuery: '',
          selectedCategory: new URLSearchParams(window.location.search).get('category') || '',
          showAllCategories: false,
          
          categories: [
              {name: 'Vegetables', icon: 'https://cdn-icons-png.flaticon.com/512/2909/2909798.png', color: 'bg-green-100'},
              {name: 'Fruits', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553691.png', color: 'bg-orange-100'},
              {name: 'Meat & Fish', icon: 'https://cdn-icons-png.flaticon.com/512/3082/3082055.png', color: 'bg-red-100'},
              {name: 'Dairy & Milk', icon: 'https://cdn-icons-png.flaticon.com/512/2674/2674486.png', color: 'bg-blue-100'},
              {name: 'Snacks', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553629.png', color: 'bg-yellow-100'},
              {name: 'Beverages', icon: 'https://cdn-icons-png.flaticon.com/512/2405/2405479.png', color: 'bg-purple-100'},
              {name: 'Bakery', icon: 'https://cdn-icons-png.flaticon.com/512/992/992747.png', color: 'bg-amber-100'},
              {name: 'Frozen Food', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553663.png', color: 'bg-cyan-100'},
              {name: 'Personal Care', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553644.png', color: 'bg-pink-100'},
              {name: 'Household', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553616.png', color: 'bg-gray-100'},
              {name: 'Baby Care', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553602.png', color: 'bg-rose-100'},
              {name: 'Pet Food', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553656.png', color: 'bg-stone-100'},
              {name: 'Canned Goods', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553591.png', color: 'bg-zinc-100'},
              {name: 'Spices', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553684.png', color: 'bg-orange-50'},
              {name: 'Breakfast', icon: 'https://cdn-icons-png.flaticon.com/512/2553/2553599.png', color: 'bg-yellow-50'},
          ],

          products: {{ json_encode($products) }}.map(p => ({...p, qty: 0})),
          isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},

          init() {
              window.addEventListener('beforeinstallprompt', (e) => {
                  e.preventDefault();
                  this.installPrompt = e;
              });
          },

          async installApp() {
              if (!this.installPrompt) return;
              this.installPrompt.prompt();
              const { outcome } = await this.installPrompt.userChoice;
              if (outcome === 'accepted') {
                  this.installPrompt = null;
              }
          },

          openQuickView(product) {
              this.selectedProduct = product;
              this.quickViewOpen = true;
          },

          formatRupiah(number) {
              return new Intl.NumberFormat('id-ID', { 
                  style: 'currency', 
                  currency: 'IDR', 
                  minimumFractionDigits: 0 
              }).format(number);
          },

          checkout() {
              if (!this.isLoggedIn) {
                  alert('Please login to continue checkout.');
                  window.location.href = '/login';
                  return;
              }

              fetch('/checkout', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  body: JSON.stringify({
                      items: this.products.filter(p => p.qty > 0)
                  })
              })
              .then(async response => {
                  if (!response.ok) {
                      const text = await response.text();
                      throw new Error(text);
                  }
                  return response.json();
              })
              .then(data => {
                  if (data.error) {
                      alert('Gagal: ' + data.error);
                      return;
                  }
                  window.snap.pay(data.snap_token, {
                      onSuccess: function(result){ 
                          alert('Payment success!'); 
                          window.location.reload(); 
                      },
                      onPending: function(result){ 
                          alert('Waiting for payment!'); 
                          console.log(result); 
                      },
                      onError: function(result){ 
                          alert('Payment failed!'); 
                          console.log(result); 
                      },
                      onClose: function(){ 
                          console.log('Customer closed the popup without finishing the payment'); 
                      }
                  });
              })
              .catch(error => {
                  console.error('Error:', error);
                  if (error.message && error.message.includes('<!doctype html>')) {
                      alert('Terjadi Error di Server. Cek Console (F12) untuk detailnya.');
                  } else {
                      alert('Gagal: ' + error.message);
                  }
              });
          },
          
          addToCart(item) { item.qty++; },
          removeFromCart(item) { if(item.qty > 0) item.qty--; },
          
          get cartCount() { 
              return this.products.reduce((acc, item) => acc + item.qty, 0); 
          },
          
          get cartTotal() { 
              return this.products.reduce((acc, item) => acc + (item.price * item.qty), 0); 
          },
          
          get filteredProducts() {
              let items = this.products;
              
              if (this.selectedCategory) {
                  items = items.filter(item => item.type === this.selectedCategory);
              }
              if (this.searchQuery) {
                  items = items.filter(item => 
                      item.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                  );
              }
              return items;
          }
      }">

    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 shadow-sm border-b border-gray-100 transition-all">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-ruble-main rounded-xl flex items-center justify-center text-white text-xl shadow-lg group-hover:rotate-12 transition">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <span class="text-2xl font-bold text-ruble-dark tracking-tight">
                    Ruble<span class="text-ruble-main">Retails</span>
                </span>
            </a>

            <!-- Search Bar -->
            <div class="hidden md:flex relative w-1/3">
                <input x-model="searchQuery" 
                       type="text" 
                       placeholder="Search for grocery, vegetables, or meat..." 
                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition shadow-inner text-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-3.5 text-gray-400"></i>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-6">
                <!-- Location -->
                <div class="hidden lg:flex items-center gap-2 text-sm text-gray-500 bg-gray-50 px-3 py-1.5 rounded-full border border-gray-100">
                    <i class="fa-solid fa-location-dot text-ruble-main"></i>
                    <span>Bandung, ID</span>
                    <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
                </div>

                <!-- Install Button -->
                <button x-show="installPrompt" 
                        x-cloak
                        @click="installApp()" 
                        class="hidden md:flex items-center gap-2 bg-ruble-main text-white px-4 py-2 rounded-full font-bold text-sm hover:bg-ruble-dark transition shadow-md animate-pulse">
                    <i class="fa-solid fa-download"></i> Install App
                </button>

                <!-- Cart Button -->
                <button @click="cartOpen = !cartOpen" class="relative group">
                    <div class="w-10 h-10 rounded-full bg-gray-50 group-hover:bg-ruble-light flex items-center justify-center transition border border-gray-100">
                        <i class="fa-solid fa-basket-shopping text-gray-600 group-hover:text-ruble-dark"></i>
                    </div>
                    <div x-show="cartCount > 0" 
                         x-transition.scale
                         x-cloak
                         class="absolute -top-1 -right-1 bg-ruble-accent text-ruble-dark text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-sm border border-white"
                         x-text="cartCount">
                    </div>
                </button>

                <!-- Auth Buttons / User Menu -->
                @guest
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-ruble-main transition">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="bg-ruble-dark text-white px-5 py-2 rounded-full font-bold text-sm hover:bg-ruble-main transition shadow-md">
                        Sign Up
                    </a>
                </div>
                @endguest

                @auth
                <div x-data="{ open: false }" class="relative">
                    <div @click="open = !open" class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1.5 pr-3 rounded-full transition border border-transparent hover:border-gray-100">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0f393b&color=fff" 
                             class="w-9 h-9 rounded-full shadow-sm" 
                             alt="Profile">
                        <div class="hidden lg:block text-left">
                            <p class="text-xs text-gray-500">Welcome,</p>
                            <p class="text-sm font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    
                    <div x-show="open" 
                         @click.away="open = false" 
                         x-cloak
                         class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl z-[100] py-2 border border-gray-100">
                        <a href="{{ route('admin.products.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 text-sm text-ruble-main font-bold hover:bg-teal-50 transition">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            Manage Products
                        </a>
                        <a href="{{ route('profile') }}" 
                           class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition border-t border-gray-50">
                            <i class="fa-solid fa-user text-gray-400"></i>
                            My Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 font-bold hover:bg-red-50 transition border-t border-gray-50">
                                <i class="fa-solid fa-power-off"></i>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20">
        
        <!-- Hero Section -->
        <div class="bg-ruble-main relative overflow-hidden pb-16 pt-10 rounded-b-[60px] shadow-xl mx-4 lg:mx-8">
            <div class="container mx-auto px-6 flex flex-col-reverse lg:flex-row items-center justify-between relative z-10">
                
                <!-- Hero Text -->
                <div class="lg:w-1/2 text-white mt-8 lg:mt-0 text-center lg:text-left">
                    <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm mb-4 inline-block border border-white/30">
                        🚀 Free delivery on orders over Rp 100.000
                    </span>
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                        Organic food <br> delivered to <span class="text-ruble-accent italic font-serif">your door.</span>
                    </h1>
                    <p class="text-teal-50 text-lg mb-8 max-w-lg mx-auto lg:mx-0">
                        Get fresh organic produce and sustainably sourced groceries delivered in as little as 15 minutes.
                    </p>
                    <div class="flex items-center gap-4 justify-center lg:justify-start">
                        <button class="bg-ruble-accent text-ruble-dark px-8 py-3.5 rounded-full font-bold hover:bg-yellow-300 hover:scale-105 transition shadow-lg shadow-yellow-500/20">
                            Shop Now
                        </button>
                        <button class="bg-white/10 backdrop-blur text-white px-6 py-3.5 rounded-full font-semibold hover:bg-white/20 transition border border-white/20 flex items-center gap-2">
                            <i class="fa-solid fa-play bg-white text-ruble-main rounded-full w-6 h-6 flex items-center justify-center text-xs"></i>
                            How it works
                        </button>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="lg:w-1/2 flex justify-center lg:justify-end relative">
                    <div class="absolute w-96 h-96 bg-white/10 rounded-full blur-3xl -top-10 -right-10"></div>
                    <img src="https://cdn-icons-png.flaticon.com/512/3082/3082011.png" 
                         alt="Grocery Basket" 
                         class="w-80 lg:w-[500px] drop-shadow-2xl hover:scale-105 transition duration-700 ease-in-out transform hover:-rotate-2 relative z-10">
                    
                    <div class="absolute bottom-10 -left-10 bg-white p-3 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce" 
                         style="animation-duration: 3s;">
                        <div class="bg-green-100 p-2 rounded-lg text-green-600">
                            <i class="fa-solid fa-carrot"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Freshness</p>
                            <p class="font-bold text-gray-800">100% Organic</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="container mx-auto px-6 mt-12">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Browse Categories</h2>
                    <p class="text-gray-400 text-sm mt-1">Select from our wide range of products</p>
                </div>
                <a href="#" 
                   @click.prevent="showAllCategories = !showAllCategories" 
                   class="text-ruble-main font-semibold hover:underline flex items-center gap-1">
                    <span x-text="showAllCategories ? 'Show Less' : 'View All'"></span>
                    <i class="fa-solid text-xs" 
                       :class="showAllCategories ? 'fa-chevron-up' : 'fa-arrow-right'"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <template x-for="cat in (showAllCategories ? categories : categories.slice(0, 5))" :key="cat.name">
                    <div @click="selectedCategory = (selectedCategory === cat.name ? '' : cat.name)"
                         :class="selectedCategory === cat.name ? 'border-ruble-main ring-1 ring-ruble-main bg-ruble-light/30' : 'border-gray-100 bg-white'"
                         class="p-6 rounded-2xl border shadow-sm hover:shadow-md hover:border-ruble-main transition cursor-pointer group flex flex-col items-center text-center">
                        <div :class="cat.color" 
                             class="w-16 h-16 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition duration-300">
                            <img :src="cat.icon" 
                                 class="w-8 h-8 opacity-80 group-hover:opacity-100 transition">
                        </div>
                        <h3 class="font-bold text-gray-700 group-hover:text-ruble-main transition" 
                            x-text="cat.name"></h3>
                    </div>
                </template>
            </div>
        </div>

        <!-- Products Section -->
        <div class="container mx-auto px-6 mt-16 mb-20" id="products">
            <div class="flex items-center gap-3 mb-8">
                <h2 class="text-2xl font-bold text-gray-800" 
                    x-text="selectedCategory ? selectedCategory : 'Weekly Best Selling'"></h2>
                <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-md font-bold uppercase tracking-wider">Hot</span>
            </div>

            <div x-show="filteredProducts.length === 0" 
                 x-cloak
                 class="text-center py-20">
                <p class="text-gray-500 text-lg">No products found.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <template x-for="product in filteredProducts" :key="product.id">
                    <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition duration-300 relative group flex flex-col justify-between h-full"
                         :class="{'border-ruble-main ring-1 ring-ruble-main': product.qty > 0}">
                        
                        <!-- Discount Badge -->
                        <span x-show="product.id % 2 == 0" 
                              x-cloak
                              class="absolute top-4 left-4 bg-red-100 text-red-600 text-[10px] font-bold px-2 py-1 rounded-md">
                            10% OFF
                        </span>

                        <!-- Product Image -->
                        <div class="bg-gray-50 rounded-2xl h-48 flex items-center justify-center mb-4 relative overflow-hidden">
                            <a :href="'/product/' + product.id" class="cursor-pointer block">
                                <img :src="product.image" 
                                     class="w-28 drop-shadow-md group-hover:scale-110 transition duration-500 ease-in-out">
                            </a>
                            <button @click="openQuickView(product)" 
                                    class="absolute bottom-2 translate-y-10 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition duration-300 bg-white text-gray-800 text-xs font-bold px-4 py-2 rounded-full shadow-md hover:bg-ruble-dark hover:text-white">
                                Quick View
                            </button>
                        </div>

                        <!-- Product Info -->
                        <div>
                            <div class="flex justify-between items-start">
                                <div>
                                    <a :href="'/product/' + product.id" 
                                       class="hover:text-ruble-main transition">
                                        <h3 class="font-bold text-gray-800 text-lg" 
                                            x-text="product.name"></h3>
                                    </a>
                                    <p class="text-xs text-gray-400 mb-1" 
                                       x-text="product.type"></p>
                                </div>
                                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-lg" 
                                     x-text="product.weight"></div>
                            </div>
                            
                            <!-- Price & Cart Actions -->
                            <div class="flex justify-between items-end mt-4">
                                <div>
                                    <span class="text-xs text-gray-400 line-through mr-1" 
                                          x-show="product.id % 2 == 0"
                                          x-cloak>
                                        <span x-text="formatRupiah(product.price * 1.1)"></span>
                                    </span>
                                    <div class="text-xl font-bold text-gray-900">
                                        <span x-text="formatRupiah(product.price)"></span>
                                    </div>
                                </div>

                                <div>
                                    <!-- Add to Cart Button -->
                                    <button x-show="product.qty === 0" 
                                            x-cloak
                                            @click="addToCart(product)"
                                            class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-600 hover:bg-ruble-main hover:text-white transition shadow-sm hover:shadow-lg hover:shadow-teal-500/30">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>

                                    <!-- Quantity Controls -->
                                    <div x-show="product.qty > 0" 
                                         x-transition.opacity
                                         x-cloak
                                         class="flex items-center gap-2 bg-ruble-light p-1 rounded-xl border border-ruble-main">
                                        <button @click="removeFromCart(product)" 
                                                class="w-7 h-7 bg-white rounded-lg flex items-center justify-center text-ruble-dark hover:bg-red-50 hover:text-red-500 transition shadow-sm text-xs">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span class="font-bold text-ruble-dark w-4 text-center text-sm" 
                                              x-text="product.qty"></span>
                                        <button @click="addToCart(product)" 
                                                class="w-7 h-7 bg-ruble-main rounded-lg flex items-center justify-center text-white hover:bg-ruble-dark transition shadow-sm text-xs">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    <!-- Company Info -->
                    <div class="col-span-1 md:col-span-1">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 bg-ruble-main rounded-lg flex items-center justify-center text-white">
                                <i class="fa-solid fa-leaf"></i>
                            </div>
                            <span class="text-xl font-bold text-ruble-dark">
                                Ruble<span class="text-ruble-main">Retails</span>
                            </span>
                        </div>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">
                            We bring the store to your door. High quality products and organic ingredients directly from farmers.
                        </p>
                        <div class="flex gap-4">
                            <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-ruble-main hover:text-white transition">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-ruble-main hover:text-white transition">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-ruble-main hover:text-white transition">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Company Links -->
                    <div>
                        <h4 class="font-bold text-gray-800 mb-4">Company</h4>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="{{ route('about') }}" class="hover:text-ruble-main transition">About Us</a></li>
                            <li><a href="{{ route('delivery') }}" class="hover:text-ruble-main transition">Delivery Information</a></li>
                            <li><a href="{{ route('privacy') }}" class="hover:text-ruble-main transition">Privacy Policy</a></li>
                            <li><a href="{{ route('terms') }}" class="hover:text-ruble-main transition">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    
                    <!-- Categories -->
                    <div>
                        <h4 class="font-bold text-gray-800 mb-4">Categories</h4>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="/?category=Dairy%20%26%20Milk#products" class="hover:text-ruble-main transition">Dairy & Milk</a></li>
                            <li><a href="/?category=Fruits#products" class="hover:text-ruble-main