<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Ruble Retails</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
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

    <div class="hidden lg:flex w-1/2 bg-ruble-main relative items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1610348725531-843dff563e2c?q=80&w=2670&auto=format&fit=crop')] bg-cover bg-center opacity-30 mix-blend-multiply"></div>
        <div class="relative z-10 text-center text-white px-10">
            <h1 class="text-4xl font-bold mb-4">Join Ruble Retails</h1>
            <p class="text-lg text-teal-100">Create an account today and get free delivery on your first organic order.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white p-8 md:p-12 relative overflow-y-auto">
        <div class="w-full max-w-md py-10">
            <h2 class="text-3xl font-bold text-ruble-dark mb-2">Create Account</h2>
            <p class="text-gray-500 mb-8">Start your healthy journey with us.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <div class="relative">
                        <input type="text" name="name" required placeholder="John Doe" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition">
                        <i class="fa-regular fa-user absolute left-3.5 top-3.5 text-gray-400"></i>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" required placeholder="name@example.com" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition">
                        <i class="fa-regular fa-envelope absolute left-3.5 top-3.5 text-gray-400"></i>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-gray-400"></i>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" required placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition">
                        <i class="fa-solid fa-check-double absolute left-3.5 top-3.5 text-gray-400"></i>
                    </div>
                </div>

                <button type="submit" class="w-full bg-ruble-main text-white py-3.5 rounded-xl font-bold shadow-lg hover:bg-ruble-dark hover:shadow-teal-500/30 transition duration-300">
                    Sign Up
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-bold text-ruble-main hover:text-ruble-dark transition">Sign In</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>