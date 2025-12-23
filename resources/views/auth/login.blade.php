<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Ruble Retails</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ruble: { dark: '#0f393b', main: '#14b8a6', light: '#ccfbf1', accent: '#facc15' }
                    },
                    fontFamily: { sans: ['Instrument Sans', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased h-screen flex overflow-hidden">

    <div class="hidden lg:flex w-1/2 bg-ruble-dark relative items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=2574&auto=format&fit=crop')] bg-cover bg-center opacity-40"></div>
        <div class="relative z-10 text-center text-white px-10">
            <div class="w-16 h-16 bg-ruble-main rounded-2xl flex items-center justify-center text-3xl shadow-lg mx-auto mb-6">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <h1 class="text-4xl font-bold mb-4">Welcome Back!</h1>
            <p class="text-lg text-gray-200">Continue your journey with the freshest organic groceries delivered to your doorstep.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white p-8 md:p-12 relative">
        <a href="/" class="lg:hidden absolute top-8 left-8 flex items-center gap-2">
            <div class="w-8 h-8 bg-ruble-main rounded-lg flex items-center justify-center text-white"><i class="fa-solid fa-leaf"></i></div>
            <span class="text-xl font-bold text-ruble-dark">Ruble</span>
        </a>

        <div class="w-full max-w-md">
            <h2 class="text-3xl font-bold text-ruble-dark mb-2">Sign In</h2>
            <p class="text-gray-500 mb-8">Please login to your account.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" required placeholder="name@example.com" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition">
                        <i class="fa-regular fa-envelope absolute left-3.5 top-3.5 text-gray-400"></i>
                    </div>
                </div>

                <div class="mb-5" x-data="{ show: false }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••" 
                            class="w-full pl-10 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-gray-400"></i>
                        <button type="button" @click="show = !show" class="absolute right-3.5 top-3.5 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-ruble-main rounded border-gray-300 focus:ring-ruble-main">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-ruble-main hover:text-ruble-dark transition">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full bg-ruble-dark text-white py-3.5 rounded-xl font-bold shadow-lg hover:bg-ruble-main hover:shadow-teal-500/30 transition duration-300">
                    Sign In
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-bold text-ruble-main hover:text-ruble-dark transition">Sign Up Free</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>