<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - Ruble Retails</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
<body class="bg-ruble-dark font-sans text-gray-800 antialiased h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute w-96 h-96 bg-ruble-main rounded-full blur-[128px] -top-20 -left-20 opacity-30"></div>
    <div class="absolute w-96 h-96 bg-ruble-accent rounded-full blur-[128px] bottom-0 right-0 opacity-10"></div>

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 md:p-12 relative z-10 text-center">
        
        <div class="w-16 h-16 bg-ruble-light rounded-full flex items-center justify-center text-ruble-dark text-2xl mx-auto mb-6">
            <i class="fa-solid fa-key"></i>
        </div>

        <h1 class="text-2xl font-bold text-ruble-dark mb-2">Forgot Password?</h1>
        <p class="text-gray-500 mb-8 text-sm leading-relaxed">
            No worries! Enter your email address below and we will send you a password reset link.
        </p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6 text-left">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" required placeholder="name@example.com" 
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-ruble-main focus:bg-white transition">
                    <i class="fa-regular fa-envelope absolute left-3.5 top-3.5 text-gray-400"></i>
                </div>
            </div>

            <button type="submit" class="w-full bg-ruble-main text-white py-3.5 rounded-xl font-bold shadow-lg hover:bg-ruble-dark hover:shadow-teal-500/30 transition duration-300">
                Send Reset Link
            </button>
        </form>

        <div class="mt-8">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-400 hover:text-ruble-main transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Login
            </a>
        </div>
    </div>

</body>
</html>