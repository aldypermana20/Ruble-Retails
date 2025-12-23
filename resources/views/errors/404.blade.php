<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found - Ruble Retails</title>
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
<body class="bg-gray-50 font-sans text-gray-800 antialiased flex items-center justify-center min-h-screen">
    <div class="text-center px-6">
        <div class="w-24 h-24 bg-ruble-light rounded-full flex items-center justify-center mx-auto mb-6 text-ruble-main text-4xl">
            <i class="fa-solid fa-compass"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-2">404 - Page Not Found</h1>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        
        <a href="{{ url('/') }}" class="inline-block bg-ruble-dark text-white px-8 py-3 rounded-full font-bold hover:bg-ruble-main transition shadow-lg">
            Back to Home
        </a>
    </div>
</body>
</html>
