<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Ruble Retails</title>
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
<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    <nav class="bg-white shadow-sm border-b border-gray-100">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-ruble-main rounded-xl flex items-center justify-center text-white text-xl shadow-lg">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <span class="text-2xl font-bold text-ruble-dark tracking-tight">Ruble<span class="text-ruble-main">Retails</span></span>
            </a>
            
            <div class="flex items-center gap-4">
                <a href="/" class="text-sm font-bold text-gray-500 hover:text-ruble-main transition">Back to Store</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-ruble-dark mb-6">About Us</h1>
            
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 prose max-w-none">
                <p class="text-lg text-gray-600 mb-4">Welcome to <span class="font-bold text-ruble-main">Ruble Retails</span>. We are dedicated to providing the best service possible.</p>
                <p class="text-gray-600 mb-4">Our mission is to deliver high quality products to our customers directly from organic farms.</p>
                <p class="text-gray-600">Contact us at: <a href="mailto:info@rubleretails.com" class="text-ruble-main hover:underline">info@rubleretails.com</a></p>
            </div>
        </div>
    </div>
</body>
</html>