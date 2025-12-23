<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Internet Connection - Ruble Retails</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('icons/icon-192x192.png') }}" type="image/png">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ruble: {
                            red: '#EF4444',
                            darkRed: '#DC2626',
                            orange: '#F59E0B',
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-up': 'slideUp 0.6s ease-out forwards',
                    },
                    keyframes: {
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-ruble-red to-ruble-darkRed min-h-screen flex items-center justify-center p-4 font-sans text-white overflow-hidden relative">

    <!-- Background Decoration -->
    <i class="fa-solid fa-wifi absolute -top-20 -right-20 text-[300px] opacity-5 rotate-12"></i>
    <i class="fa-solid fa-cloud absolute bottom-10 left-10 text-[150px] opacity-5"></i>

    <main class="w-full max-w-2xl flex flex-col items-center text-center relative z-10 animate-slide-up">
        
        <!-- Status Badge -->
        <div id="status-badge" class="mb-8 px-6 py-3 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center gap-3 transition-all duration-300">
            <span id="status-dot" class="w-3 h-3 rounded-full bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.8)] animate-pulse"></span>
            <span id="status-text" class="font-semibold text-sm tracking-wide">Tidak ada koneksi</span>
        </div>

        <!-- Icon -->
        <div class="relative mb-6">
            <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm animate-pulse-slow">
                <i class="fa-solid fa-wifi text-6xl text-white/90"></i>
            </div>
            <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-ruble-red text-xl shadow-lg">
                <i class="fa-solid fa-xmark"></i>
            </div>
        </div>

        <!-- Content -->
        <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-md">
            Maaf, Anda Sedang Offline
        </h1>
        <p class="text-lg text-white/90 max-w-lg mb-10 leading-relaxed">
            Koneksi internet Anda terputus. Silakan periksa koneksi Anda agar dapat kembali berbelanja kebutuhan harian Anda.
        </p>

        <!-- CTA Button -->
        <button onclick="retryConnection()" class="group bg-white text-ruble-red px-10 py-4 rounded-full font-bold text-lg shadow-xl hover:bg-gray-50 hover:scale-105 hover:shadow-2xl transition-all duration-300 flex items-center gap-3">
            <i class="fa-solid fa-rotate-right group-hover:rotate-180 transition-transform duration-700"></i>
            Coba Lagi
        </button>

        <!-- Tips Section -->
        <div class="mt-12 w-full bg-black/20 backdrop-blur-md rounded-2xl p-6 md:p-8 text-left border border-white/10">
            <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                <i class="fa-regular fa-lightbulb text-ruble-orange"></i> Tips Mengatasi Masalah:
            </h3>
            <ul class="space-y-3 text-sm md:text-base text-white/80">
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-ruble-orange mt-1"></i>
                    <span>Periksa koneksi WiFi atau data seluler Anda.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-ruble-orange mt-1"></i>
                    <span>Pastikan mode pesawat (airplane mode) tidak aktif.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-ruble-orange mt-1"></i>
                    <span>Coba muat ulang halaman ini setelah beberapa saat.</span>
                </li>
            </ul>
        </div>

    </main>

    <!-- JavaScript Logic -->
    <script>
        const statusBadge = document.getElementById('status-badge');
        const statusDot = document.getElementById('status-dot');
        const statusText = document.getElementById('status-text');

        function updateOnlineStatus() {
            if (navigator.onLine) {
                // Online State
                statusBadge.classList.remove('bg-white/20', 'border-white/30');
                statusBadge.classList.add('bg-green-500/20', 'border-green-400/50');
                
                statusDot.classList.remove('bg-red-500', 'animate-pulse');
                statusDot.classList.add('bg-green-400', 'shadow-[0_0_10px_rgba(74,222,128,0.8)]');
                
                statusText.innerText = "Terhubung kembali!";
                
                // Auto reload after delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                // Offline State
                statusBadge.classList.add('bg-white/20', 'border-white/30');
                statusBadge.classList.remove('bg-green-500/20', 'border-green-400/50');
                
                statusDot.classList.add('bg-red-500', 'animate-pulse');
                statusDot.classList.remove('bg-green-400');
                
                statusText.innerText = "Tidak ada koneksi";
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);

        // Initial check
        updateOnlineStatus();

        // Manual Retry
        function retryConnection() {
            const btn = document.querySelector('button i');
            btn.classList.add('animate-spin');
            
            if (navigator.onLine) {
                window.location.reload();
            } else {
                setTimeout(() => {
                    btn.classList.remove('animate-spin');
                    // Shake animation for feedback
                    const main = document.querySelector('main');
                    main.classList.add('translate-x-2');
                    setTimeout(() => main.classList.remove('translate-x-2'), 100);
                    setTimeout(() => main.classList.add('-translate-x-2'), 200);
                    setTimeout(() => main.classList.remove('-translate-x-2'), 300);
                }, 500);
            }
        }
    </script>
</body>
</html>
