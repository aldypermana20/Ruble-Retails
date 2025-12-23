<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Server Error - Ruble Retails</title>
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
    <div class="text-center px-6 w-full max-w-3xl">
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500 text-4xl animate-pulse">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-2">500 - Server Error</h1>
        <p class="text-gray-500 mb-8">Oops! Something went wrong on our end.</p>
        
        {{-- Menampilkan Detail Error untuk Debugging --}}
        @if(isset($exception))
        <div class="bg-white p-6 rounded-xl border border-red-200 shadow-sm text-left mx-auto mb-8 overflow-auto max-h-80 relative">
            <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
            <p class="text-xs font-bold text-red-500 uppercase mb-2 flex items-center gap-2">
                <i class="fa-solid fa-bug"></i> Error Details (Debug Mode)
            </p>
            <code class="text-sm font-mono text-gray-800 block whitespace-pre-wrap break-words bg-red-50 p-3 rounded-lg border border-red-100">{{ $exception->getMessage() }}</code>
        </div>
        @endif

        <a href="{{ url('/') }}" class="inline-block bg-ruble-dark text-white px-8 py-3 rounded-full font-bold hover:bg-ruble-main transition shadow-lg hover:shadow-teal-500/30">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Home
        </a>
    </div>
</body>
</html>
