# 🛒 Point of Sales (POS) - Warung Pintar

Aplikasi Kasir berbasis Web (Point of Sales) yang dirancang untuk membantu operasional warung UMKM. Aplikasi ini terintegrasi dengan **Midtrans Payment Gateway** untuk pembayaran QRIS dan mendukung teknologi **PWA (Progressive Web App)** sehingga dapat diinstal dan berjalan layaknya aplikasi native di perangkat mobile.

## 🚀 Fitur Unggulan

* **Manajemen Produk:** Tambah, Edit, Hapus (CRUD) data barang & stok.
* **Transaksi Kasir:** Antarmuka kasir yang responsif dan mudah digunakan.
* **Pembayaran Digital:** Integrasi **QRIS via Midtrans** (OVO, GoPay, Dana, LinkAja, BCA, dll).
* **PWA Ready:** Mendukung *Add to Home Screen* dan *Offline Capability* (Service Worker).
* **Manajemen User:** Sistem login aman untuk Admin/Kasir.
* **Laporan Transaksi:** Riwayat status pembayaran Real-time (Settlement/Pending/Expire).

## 🛠️ Teknologi yang Digunakan (Tech Stack)

* **Framework:** [Laravel](https://laravel.com/) (PHP Monolith)
* **Database:** MySQL
* **Frontend:** Blade Templates, Bootstrap/Tailwind CSS
* **Payment Gateway:** [Midtrans](https://midtrans.com/) (Snap API)
* **PWA:** Web App Manifest & Service Worker

## 📋 Prasyarat Sistem

Sebelum menginstal, pastikan laptop Anda sudah terinstal:
* PHP >= 8.0
* Composer
* MySQL / MariaDB
* Node.js & NPM

## ⚙️ Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di lokal:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username-anda/nama-project-kasir.git](https://github.com/username-anda/nama-project-kasir.git)
    cd nama-project-kasir
    ```

2.  **Install Dependensi PHP & JS**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database & Midtrans**
    Buka file `.env` dan sesuaikan konfigurasi berikut:

    ```ini
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=

    # Konfigurasi Midtrans (Ambil dari Dashboard Midtrans Sandbox)
    MIDTRANS_MERCHANT_ID=G-xxxxxxxxx
    MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxx
    MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxx
    MIDTRANS_IS_PRODUCTION=false
    MIDTRANS_IS_SANITIZED=true
    MIDTRANS_IS_3DS=true
    ```

6.  **Migrasi Database**
    ```bash
    php artisan migrate --seed
    ```

7.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka browser dan akses: `http://localhost:8000`

## 💳 Simulasi Pembayaran (Sandbox)

Karena aplikasi ini menggunakan mode **Sandbox (Testing)**, jangan gunakan uang asli.
1.  Lakukan transaksi di aplikasi hingga muncul QR Code.
2.  Copy URL gambar QR Code tersebut.
3.  Buka [Midtrans Simulator](https://simulator.sandbox.midtrans.com/qris/index).
4.  Paste URL dan klik **Pay/Scan**.
5.  Status transaksi di aplikasi akan otomatis berubah menjadi **PAID**.

## 📱 Cara Install PWA (Mobile)

1.  Akses website melalui browser (Chrome) di HP Android.
2.  Tunggu notifikasi **"Add to Home Screen"** muncul di bawah, atau buka menu titik tiga di pojok kanan atas > pilih **Install App**.
3.  Aplikasi akan muncul di menu utama HP Anda.

## 📝 Catatan Pengembang

Project ini dibuat untuk memenuhi tugas mata kuliah Pemrograman Web Lanjut.
* **Nama:** [Nama Anda]
* **NIM:** [NIM Anda]
* **Kampus:** [Nama Kampus]

---
*Dibuat dengan ❤️ menggunakan Laravel.*
