<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductManagerController extends Controller
{
    // Tampilan daftar barang untuk Admin
    public function index()
    {
        // Menggunakan latest() agar barang terbaru muncul di atas
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'weight' => 'required|string|max:255',
            'image' => 'required|url', // Validasi URL gambar
        ]);

        Product::create($data);

        return back()->with('success', 'Barang berhasil ditambah!');
    }

    // Update barang
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'weight' => 'required|string|max:255',
            'image' => 'nullable|url', // Image opsional saat update
        ]);

        // Hapus key 'image' jika kosong agar tidak menimpa gambar lama dengan null
        if (empty($data['image'])) {
            unset($data['image']);
        }

        $product->update($data);

        return back()->with('success', 'Barang berhasil diupdate!');
    }

    // Hapus barang
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return back()->with('success', 'Barang berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Kode error 23000 artinya Integrity Constraint Violation
            if ($e->getCode() == "23000") {
                return back()->with('error', 'Gagal hapus! Barang ini ada di riwayat pesanan pembeli. Hapus pesanan terkait dulu atau gunakan fitur "Nonaktifkan Produk".');
            }
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
