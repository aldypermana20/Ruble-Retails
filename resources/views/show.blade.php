<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - Gromuse Store</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('icons/icon-192x192.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Midtrans Snap JS -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                    colors: {
                        ruble: {
                            dark: '#0f393b',   /* Header Gelap */
                            main: '#14b8a6',   /* Hijau Utama (Teal) */
                            light: '#ccfbf1',  /* Background Aksen */
                            accent: '#facc15', /* Kuning Tombol */
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased"
      x-data="{
          cartOpen: false,
          searchQuery: '',
          isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
          products: [
              {
                  id: {{ $product->id }},
                  name: '{{ addslashes($product->name) }}',
                  price: {{ $product->price }},
                  image: '{{ $product->image }}',
                  weight: '{{ $product->weight }}',
                  qty: 0
              }
          ],
          get cartCount() { return this.products.reduce((acc, item) => acc + item.qty, 0); },
          get cartTotal() { return this.products.reduce((acc, item) => acc + (item.price * item.qty), 0); },
          
          addToCart(item) {
              let product = this.products.find(p => p.id === item.id);
              if (product) {
                  product.qty += (item.qty || 1);
              }
              this.cartOpen = true;
          },
          removeFromCart(item) {
              let product = this.products.find(p => p.id === item.id);
              if (product && product.qty > 0) product.qty--;
          },
          formatRupiah(number) {
              return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
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
                  if (!response.ok) throw new Error(await response.text());
                  return response.json();
              })
              .then(data => {
                  if (data.error) { alert('Gagal: ' + data.error); return; }
                  window.snap.pay(data.snap_token, {
                      onSuccess: function(result){ alert('Payment success!'); window.location.reload(); },
                      onPending: function(result){ alert('Waiting for payment!'); },
                      onError: function(result){ alert('Payment failed!'); },
                      onClose: function(){ }
                  });
              })
              .catch(error => {
                  alert('Error: ' + error.message);
              });
          }
      }"
      @add-to-cart.window="addToCart($event.detail)">

    <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 shadow-sm border-b border-gray-100 transition-all">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-ruble-main rounded-xl flex items-center justify-center text-white text-xl shadow-lg group-hover:rotate-12 transition">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <span class="text-2xl font-bold text-ruble-dark tracking-tight">Ruble<span class="text-ruble-main">Retails</span></span>
            </a>

            <div class="hidden md:flex relative w-1/3">
                <input x-model="searchQuery" 
                       type="text" 
                       placeholder="Search for grocery, vegetables, or meat..." 
                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition shadow-inner text-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-3.5 text-gray-400"></i>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden lg:flex items-center gap-2 text-sm text-gray-500 bg-gray-50 px-3 py-1.5 rounded-full border border-gray-100">
                    <i class="fa-solid fa-location-dot text-ruble-main"></i>
                    <span>Bandung, ID</span>
                    <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
                </div>

                <button @click="cartOpen = !cartOpen" class="relative group">
                    <div class="w-10 h-10 rounded-full bg-gray-50 group-hover:bg-ruble-light flex items-center justify-center transition border border-gray-100">
                        <i class="fa-solid fa-basket-shopping text-gray-600 group-hover:text-ruble-dark"></i>
                    </div>
                    <div x-show="cartCount > 0" 
                         x-transition.scale
                         class="absolute -top-1 -right-1 bg-ruble-accent text-ruble-dark text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-sm border border-white"
                         x-text="cartCount">
                    </div>
                </button>

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
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0f393b&color=fff" class="w-9 h-9 rounded-full shadow-sm" alt="Profile">
                        <div class="hidden lg:block text-left">
                            <p class="text-xs text-gray-500">Welcome,</p>
                            <p class="text-sm font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl z-10 py-2 border border-gray-100" style="display: none;">
                        <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-ruble-main font-bold hover:bg-gray-50">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Product Manager
                        </a>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Profile</a>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-50 font-bold">Sign Out</button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 pt-24">

        <!-- Include Standalone Component -->
        @include('product-detail', [
            'product' => $product, 
            'reviews' => $reviews, 
            'avgRating' => $avgRating, 
            'reviewCount' => $reviewCount,
            'isWishlisted' => $isWishlisted
        ])
    </main>

    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-ruble-main rounded-lg flex items-center justify-center text-white">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <span class="text-xl font-bold text-ruble-dark">Ruble<span class="text-ruble-main">Retails</span></span>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        We bring the store to your door. High quality products and organic ingredients directly from farmers.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-ruble-main hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-ruble-main hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-ruble-main hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('about') }}" class="hover:text-ruble-main transition">About Us</a></li>
                        <li><a href="{{ route('delivery') }}" class="hover:text-ruble-main transition">Delivery Information</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-ruble-main transition">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-ruble-main transition">Terms & Conditions</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Categories</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="/?category=Dairy%20%26%20Milk#products" class="hover:text-ruble-main transition">Dairy & Milk</a></li>
                        <li><a href="/?category=Fruits#products" class="hover:text-ruble-main transition">Fresh Fruit</a></li>
                        <li><a href="/?category=Meat%20%26%20Fish#products" class="hover:text-ruble-main transition">Meat & Fish</a></li>
                        <li><a href="/?category=Vegetables#products" class="hover:text-ruble-main transition">Vegetables</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Newsletter</h4>
                    <p class="text-sm text-gray-500 mb-4">Subscribe to get daily news and updates.</p>
                    <div class="flex">
                        <input type="text" placeholder="Email Address" class="bg-gray-50 border border-gray-200 rounded-l-lg px-4 py-2 text-sm w-full focus:outline-none focus:border-ruble-main">
                        <button class="bg-ruble-dark text-white px-4 py-2 rounded-r-lg text-sm font-bold hover:bg-ruble-main transition">Sub</button>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-xs text-gray-400">© 2023 Ruble Retails. All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0 opacity-50 grayscale hover:grayscale-0 transition">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" class="h-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/2560px-MasterCard_Logo.svg.png" class="h-4">
                </div>
            </div>
        </div>
    </footer>

    <div x-show="cartOpen" 
            style="display: none;"
            class="fixed inset-0 z-[60]" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        
        <div x-show="cartOpen"
                x-transition:enter="ease-in-out duration-500"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                @click="cartOpen = false"></div>

        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none">
            <div x-show="cartOpen"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto w-screen max-w-md">
                
                <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl">
                    <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                        <div class="flex items-start justify-between border-b border-gray-100 pb-4">
                            <h2 class="text-lg font-bold text-gray-900" id="slide-over-title">Shopping Cart</h2>
                            <div class="ml-3 flex h-7 items-center">
                                <button @click="cartOpen = false" type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                    <i class="fa-solid fa-xmark text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="flow-root">
                                <div x-show="cartCount === 0" class="text-center py-10">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fa-solid fa-basket-shopping text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500">Your cart is empty.</p>
                                    <button @click="cartOpen = false" class="mt-4 text-ruble-main font-bold hover:underline">Start Shopping</button>
                                </div>

                                <ul role="list" class="-my-6 divide-y divide-gray-200">
                                    <template x-for="item in products.filter(p => p.qty > 0)" :key="item.id">
                                        <li class="flex py-6">
                                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-gray-50 p-2 flex items-center justify-center">
                                                <img :src="item.image" class="h-full w-full object-contain object-center">
                                            </div>
                                            <div class="ml-4 flex flex-1 flex-col">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3 x-text="item.name"></h3>
                                                        <p class="ml-4"><span x-text="formatRupiah(item.price * item.qty)"></span></p>
                                                    </div>
                                                    <p class="mt-1 text-sm text-gray-500" x-text="item.weight"></p>
                                                </div>
                                                <div class="flex flex-1 items-end justify-between text-sm">
                                                    <div class="flex items-center gap-2 bg-gray-100 rounded-lg p-1">
                                                        <button @click="removeFromCart(item)" class="w-6 h-6 bg-white rounded shadow text-gray-600 hover:text-red-500"><i class="fa-solid fa-minus text-xs"></i></button>
                                                        <span class="font-bold w-4 text-center" x-text="item.qty"></span>
                                                        <button @click="addToCart(item)" class="w-6 h-6 bg-white rounded shadow text-gray-600 hover:text-green-500"><i class="fa-solid fa-plus text-xs"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6 bg-gray-50" x-show="cartCount > 0">
                        <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                            <p>Subtotal</p>
                            <p><span x-text="formatRupiah(cartTotal)"></span></p>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500 mb-6">Shipping and taxes calculated at checkout.</p>
                        <button @click="checkout()" class="flex items-center justify-center rounded-xl border border-transparent bg-ruble-dark px-6 py-4 text-base font-medium text-white shadow-sm hover:bg-ruble-main transition w-full">
                            Checkout
                        </button>
                        <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                            <p>
                                or
                                <button @click="cartOpen = false" type="button" class="font-medium text-ruble-main hover:text-ruble-dark">
                                    Continue Shopping
                                    <span aria-hidden="true"> &rarr;</span>
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
