<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ruble Retails</title>

    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ruble: {
                            dark: '#0f393b',
                            main: '#14b8a6',
                            light: '#ccfbf1',
                            accent: '#facc15'
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800"
    x-data="{ 
          modalOpen: false,
          isEdit: false,
          modalTitle: '',
          formAction: '',
          // Data dummy untuk form reset
          form: { name: '', price: '', type: '', weight: '', image: '' },

          openAddModal() {
              this.modalOpen = true;
              this.isEdit = false;
              this.modalTitle = 'Tambah Produk Baru';
              this.formAction = '{{ route('admin.products.store') }}';
              this.form = { name: '', price: '', type: 'Vegetables', weight: '', image: '' };
          },

          openEditModal(product, updateUrl) {
              this.modalOpen = true;
              this.isEdit = true;
              this.modalTitle = 'Edit Produk';
              this.formAction = updateUrl;
              this.form = { 
                  name: product.name, 
                  price: product.price, 
                  type: product.type, 
                  weight: product.weight, 
                  image: product.image 
              };
          }
      }">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-ruble-dark text-white hidden md:flex flex-col fixed h-full z-10">
            <div class="h-20 flex items-center justify-center border-b border-gray-700">
                <span class="text-2xl font-bold">Ruble<span class="text-ruble-main">Admin</span></span>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-ruble-main rounded-xl text-white shadow-lg font-medium">
                    <i class="fa-solid fa-box-open"></i> Products
                </a>
                <a href="/" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-white/10 rounded-xl transition">
                    <i class="fa-solid fa-store"></i> Back to Store
                </a>
            </nav>
        </aside>

        <main class="flex-1 md:ml-64 p-6 lg:p-10">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Product Management</h1>
                    <p class="text-gray-500 text-sm mt-1">Manage your inventory, prices, and stock.</p>
                </div>
                <button @click="openAddModal()" class="bg-ruble-main hover:bg-ruble-dark text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-teal-500/30 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add Product
                </button>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm flex justify-between items-center" x-data="{ show: true }" x-show="show">
                <div>
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
                <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
            </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                                <th class="p-6 font-semibold">Image</th>
                                <th class="p-6 font-semibold">Product Name</th>
                                <th class="p-6 font-semibold">Category</th>
                                <th class="p-6 font-semibold">Price</th>
                                <th class="p-6 font-semibold">Weight</th>
                                <th class="p-6 font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($products as $product)
                            <tr class="hover:bg-ruble-light/20 transition group">
                                <td class="p-4 pl-6">
                                    <div class="w-16 h-16 bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200 p-1">
                                        <img src="{{ $product->image }}" class="w-full h-full object-contain" alt="img">
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="font-bold text-gray-800">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-400">ID: #{{ $product->id }}</div>
                                </td>
                                <td class="p-6">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold border border-gray-200">
                                        {{ $product->type }}
                                    </span>
                                </td>
                                <td class="p-6 font-bold text-ruble-dark">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="p-6 text-sm text-gray-500">{{ $product->weight }}</td>
                                <td class="p-6 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition">
                                        <button
                                            @click="openEditModal({{ json_encode($product) }}, '{{ route('admin.products.update', $product->id) }}')"
                                            class="w-9 h-9 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition"
                                            title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-9 h-9 bg-red-50 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-600 hover:text-white transition" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-box-open text-4xl mb-3 text-gray-300"></i>
                                        <p>No products found in database.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div x-show="modalOpen"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">

        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
            x-show="modalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="modalOpen = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all w-full max-w-lg"
                x-show="modalOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900" x-text="modalTitle"></h3>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-500">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form :action="formAction" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH" :disabled="!isEdit">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                        <input type="text" name="name" x-model="form.name" required
                            class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-ruble-main outline-none transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp)</label>
                            <input type="number" name="price" x-model="form.price" required
                                class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-ruble-main outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight (e.g. 1kg)</label>
                            <input type="text" name="weight" x-model="form.weight" required
                                class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-ruble-main outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="type" x-model="form.type" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-ruble-main outline-none transition bg-white">
                            <option value="Vegetables">Vegetables</option>
                            <option value="Fruits">Fruits</option>
                            <option value="Meat & Fish">Meat & Fish</option>
                            <option value="Dairy & Milk">Dairy & Milk</option>
                            <option value="Beverages">Beverages</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                        <input type="url" name="image" x-model="form.image" placeholder="https://..." required
                            class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-ruble-main outline-none transition">
                        <p class="text-xs text-gray-500 mt-1">Paste image link from internet.</p>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="modalOpen = false" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-ruble-main text-white font-bold hover:bg-ruble-dark transition shadow-lg shadow-teal-500/30">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm flex justify-between items-center" x-data="{ show: true }" x-show="show">
        <div>
            <p class="font-bold">Gagal!</p>
            <p>{{ session('error') }}</p>
        </div>
        <button @click="show = false"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif
</body>

</html>