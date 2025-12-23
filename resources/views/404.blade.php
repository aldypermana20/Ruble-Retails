<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Ruble Retails</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('icons/icon-192x192.png') }}" type="image/png">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ruble: {
                            turquoise: '#2DD4BF',
                            teal: '#14B8A6',
                            darkTeal: '#0D9488',
                            yellow: '#FDB022',
                            orange: '#F59E0B',
                            darkOrange: '#D97706',
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-ruble-turquoise to-ruble-teal min-h-screen flex flex-col font-sans text-white overflow-hidden relative selection:bg-ruble-yellow selection:text-ruble-darkTeal">

    <!-- Decorative Background Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-10">
        <i class="fa-solid fa-carrot absolute top-10 left-10 text-6xl animate-float" style="animation-delay: 0s;"></i>
        <i class="fa-solid fa-apple-whole absolute bottom-20 right-20 text-8xl animate-float" style="animation-delay: 2s;"></i>
        <i class="fa-solid fa-lemon absolute top-1/3 right-10 text-5xl animate-float" style="animation-delay: 1s;"></i>
        <i class="fa-solid fa-cart-shopping absolute bottom-10 left-1/4 text-7xl animate-float" style="animation-delay: 3s;"></i>
    </div>

    <!-- Header -->
    <nav class="w-full p-6 flex justify-between items-center relative z-10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-ruble-teal text-lg shadow-lg">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <span class="text-xl font-bold tracking-tight">Ruble<span class="text-white/90">Retails</span></span>
        </div>
        <a href="/" class="text-sm font-semibold hover:text-ruble-yellow transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Back to Home
        </a>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 relative z-10 animate-fade-in">
        
        <!-- 404 Illustration -->
        <div class="relative mb-8">
            <h1 class="text-[150px] md:text-[180px] font-extrabold leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-white to-white/20 drop-shadow-sm animate-float">
                404
            </h1>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full flex justify-center">
                <i class="fa-solid fa-magnifying-glass text-6xl md:text-8xl text-ruble-yellow drop-shadow-lg rotate-12"></i>
            </div>
        </div>

        <h2 class="text-3xl md:text-4xl font-bold mb-4 drop-shadow-md">
            Oops! Halaman Tidak Ditemukan
        </h2>
        
        <p class="text-lg md:text-xl text-white/90 max-w-lg mb-10 leading-relaxed">
            Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan, dihapus, atau URL yang Anda masukkan salah.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <a href="/" class="group bg-ruble-yellow text-gray-900 px-8 py-4 rounded-full font-bold shadow-lg hover:bg-white hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-house group-hover:text-ruble-teal transition-colors"></i>
                Kembali ke Beranda
            </a>
            
            <a href="/products" class="group border-2 border-white/30 bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-full font-bold hover:bg-white hover:text-ruble-teal transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-basket-shopping"></i>
                Lihat Produk
            </a>
        </div>

        <!-- Search Bar (Optional) -->
        <div class="mt-12 w-full max-w-md">
            <p class="text-sm mb-3 opacity-80">Atau coba cari produk yang Anda inginkan:</p>
            <div class="relative group">
                <input type="text" placeholder="Search fruits, vegetables..." 
                       class="w-full pl-12 pr-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-full text-white placeholder-white/60 focus:outline-none focus:bg-white focus:text-gray-800 focus:ring-4 focus:ring-ruble-yellow/50 transition-all shadow-inner">
                <i class="fa-solid fa-search absolute left-5 top-3.5 text-white/70 group-focus-within:text-gray-400 transition-colors"></i>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="mt-8 flex flex-wrap justify-center gap-4 text-sm font-medium text-white/80">
            <span>Popular:</span>
            <a href="#" class="hover:text-ruble-yellow hover:underline decoration-2 underline-offset-4 transition">Fresh Fruits</a>
            <span class="opacity-50">•</span>
            <a href="#" class="hover:text-ruble-yellow hover:underline decoration-2 underline-offset-4 transition">Vegetables</a>
            <span class="opacity-50">•</span>
            <a href="#" class="hover:text-ruble-yellow hover:underline decoration-2 underline-offset-4 transition">Meat & Fish</a>
        </div>
    </main>

    <footer class="w-full p-6 text-center text-xs text-white/50 relative z-10">
        &copy; {{ date('Y') }} Ruble Retails. All rights reserved.
    </footer>

</body>
</html>
