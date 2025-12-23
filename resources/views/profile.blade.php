<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile - Ruble Retails</title>
    <link rel="icon" href="{{ asset('icons/icon-192x192.png') }}" type="image/png">
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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased" x-data="{ openEdit: false, openDelete: false }">

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
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-3xl font-bold text-ruble-dark mb-2">My Profile</h1>
            <p class="text-gray-500 mb-8">Manage your account information.</p>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-ruble-dark h-32 relative">
                    <div class="absolute -bottom-12 left-8">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=14b8a6&color=fff&size=128" 
                             class="w-24 h-24 rounded-full border-4 border-white shadow-md" alt="Profile">
                    </div>
                </div>
                
                <div class="pt-16 px-8 pb-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                            <p class="text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button @click="openEdit = true" class="bg-ruble-main text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-ruble-dark transition">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Profile
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Full Name</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Email Address</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4">Account Actions</h3>
                        <div class="flex flex-wrap gap-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition flex items-center gap-2">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                                </button>
                            </form>
                            
                            <button @click="openDelete = true" class="px-6 py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition flex items-center gap-2">
                                <i class="fa-solid fa-trash-can"></i> Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="openEdit" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-30"></div>
            <div class="bg-white rounded-3xl p-8 max-w-md w-full z-50 shadow-2xl">
                <h2 class="text-2xl font-bold mb-4">Update Profile</h2>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full px-4 py-3 rounded-xl border @error('name') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-ruble-main outline-none">
                        @error('name')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-ruble-main outline-none">
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="openEdit = false" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="flex-1 py-3 bg-ruble-main text-white font-bold rounded-xl shadow-lg shadow-teal-200">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="openDelete" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-30"></div>
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full z-50 shadow-2xl text-center">
                <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h2 class="text-xl font-bold mb-2">Are you sure?</h2>
                <p class="text-gray-500 mb-6">This action cannot be undone. All your data will be permanently removed.</p>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" @click="openDelete = false" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-200">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>