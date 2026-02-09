# ☕ Sistem Administrasi Coffee Shop

Sistem administrasi modern untuk pengelolaan coffee shop yang dibangun dengan Laravel 12. Aplikasi ini menyediakan antarmuka yang intuitif untuk mengelola produk, transaksi, kategori, dan pegawai dengan sistem role-based access control.

## ✨ Fitur Utama

### 🎯 Dashboard Interaktif

- **Statistik Real-time**: Penjualan harian, mingguan, dan bulanan
- **Grafik Penjualan**: Visualisasi data 7 hari terakhir
- **Pelacakan Produk**: Monitor produk terlaris
- **Peringatan Stok**: Notifikasi produk dengan stok menipis

### 👥 Kontrol Akses Berbasis Role

- **Owner**: Akses penuh ke semua fitur
    - CRUD produk, kategori, dan pegawai
    - Lihat dan kelola transaksi
    - Akses laporan penjualan lengkap
- **Pegawai**: Akses terbatas
    - Edit stok dan status produk
    - Buat dan lihat transaksi
    - Lihat dashboard

### 📦 Manajemen Produk

- Tambah/edit/hapus produk
- Upload gambar produk
- Manajemen kategori
- Status aktif/non-aktif
- Filter dan pencarian real-time
- Edit terbatas untuk pegawai (hanya stok & status)

### 💰 Manajemen Transaksi

- Antarmuka Point of Sale (POS)
- Keranjang belanja interaktif
- Export transaksi ke Excel
- Riwayat transaksi lengkap
- Filter berdasarkan tanggal

### 🏷️ Manajemen Kategori (Khusus Owner)

- CRUD kategori produk
- Deskripsi detail kategori

### 👨‍💼 Manajemen Pegawai (Khusus Owner)

- Tambah/edit/hapus pegawai
- Informasi kontak lengkap
- Manajemen role

## 🛠️ Teknologi yang Digunakan

### Backend

- **Laravel 12** - PHP Framework
- **PHP 8.2+** - Server-side scripting
- **MySQL** - Manajemen database

### Frontend

- **Blade Templates** - Template engine
- **Vanilla CSS** - Custom styling
- **Font Awesome 6** - Library icon
- **Chart.js** - Visualisasi data

### Library Tambahan

- **Maatwebsite/Laravel-Excel** - Export ke Excel
- **Laravel Tinker** - REPL untuk Laravel

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk kompilasi asset)
- Web Server (Apache/Nginx)

## 🚀 Panduan Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/FajrilMaulid/web-coffe-shop.git
cd web-coffe-shop
```

### 2. Install Dependencies

```bash
# Install dependencies PHP
composer install

# Install dependencies Node
npm install
```

### 3. Setup Environment

```bash
# Salin file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffe_shop
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migrasi & Seeder

```bash
# Buat tabel database
php artisan migrate

# Isi data contoh
php artisan db:seed
```

### 6. Buat Storage Link

```bash
php artisan storage:link
```

### 7. Build Asset (Opsional)

```bash
npm run build
```

### 8. Jalankan Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

## 👤 Kredensial User Default

### Akun Owner

- **Email**: `owner@example.com`
- **Password**: `password`

### Akun Pegawai

- **Email**: `pegawai@example.com`
- **Password**: `password`

## 📖 Panduan Penggunaan

### Login

1. Akses aplikasi melalui browser
2. Masukkan email dan password
3. Klik tombol "Masuk"

### Manajemen Produk (Owner)

1. Klik menu "Produk" di sidebar
2. Klik tombol "+ Tambah Produk"
3. Isi form produk (kategori, nama, deskripsi, harga, stok, gambar)
4. Klik "Simpan"

### Edit Produk (Pegawai)

1. Klik menu "Produk"
2. Klik tombol "Edit" pada produk yang ingin diubah
3. Ubah nilai stok atau status produk
4. Klik "Update"

### Buat Transaksi

1. Klik menu "Transaksi"
2. Klik tombol "+ Transaksi Baru"
3. Pilih produk dari daftar
4. Atur jumlah item
5. Review total pembayaran
6. Klik "Proses Transaksi"

### Export Laporan

1. Klik menu "Transaksi"
2. Klik tombol "Export Excel"
3. File akan terunduh otomatis

## 📂 Struktur Proyek

```
coffe_dewek_web/
├── app/
│   ├── Http/
│   │   └── Controllers/      # Controller aplikasi
│   ├── Models/               # Model Eloquent
│   └── Middleware/           # Middleware kustom
├── database/
│   ├── migrations/           # Migrasi database
│   └── seeders/              # Seeder database
├── public/
│   ├── css/                  # CSS yang dikompilasi
│   ├── js/                   # File JavaScript
│   └── storage/              # Storage publik (symlink)
├── resources/
│   └── views/                # Template Blade
│       ├── auth/
│       ├── dashboard/
│       ├── products/
│       ├── transactions/
│       ├── categories/
│       ├── users/
│       └── layouts/
└── routes/
    └── web.php               # Route web
```

## 🎨 Fitur Tampilan

### UI/UX Modern

- Desain responsif untuk semua perangkat
- Sidebar gelap dengan styling gradient
- Efek hover interaktif
- Transisi dan animasi yang halus
- Antarmuka yang bersih dan minimalis

### Fitur Keamanan

- Middleware berbasis role
- Proteksi CSRF
- Autentikasi aman
- Validasi backend untuk aksi spesifik berdasarkan role

### Performa

- Query database yang dioptimalkan
- Loading asset yang efisien
- Filter pencarian client-side
- Transisi halaman yang halus

## 🔒 Keamanan

- **Autentikasi**: Sistem autentikasi bawaan Laravel
- **Otorisasi**: Kontrol akses berbasis role dengan middleware
- **Proteksi CSRF**: Validasi token pada semua form
- **Pencegahan SQL Injection**: Proteksi Eloquent ORM
- **Proteksi XSS**: Template escaping Blade

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan ikuti langkah berikut:

1. Fork repository ini
2. Buat branch baru (`git checkout -b fitur/fitur-keren`)
3. Commit perubahan (`git commit -m 'Menambahkan fitur keren'`)
4. Push ke branch (`git push origin fitur/fitur-keren`)
5. Buka Pull Request

## 📝 Lisensi

Proyek ini adalah perangkat lunak open-source yang dilisensikan di bawah [lisensi MIT](https://opensource.org/licenses/MIT).

## 👨‍💻 Pengembang

**Fajril Maulid**

- GitHub: [@FajrilMaulid](https://github.com/FajrilMaulid)

## 🙏 Ucapan Terima Kasih

- Laravel Framework
- Font Awesome Icons
- Chart.js untuk visualisasi data
- Maatwebsite/Laravel-Excel untuk fungsionalitas export

---

<p align="center">Dibuat dengan ☕ dan ❤️</p>
