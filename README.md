# ☕ Coffee Shop Admin System

Sistem administrasi modern untuk pengelolaan coffee shop yang dibangun dengan Laravel 12. Aplikasi ini menyediakan antarmuka yang intuitif untuk mengelola produk, transaksi, kategori, dan pegawai dengan sistem role-based access control.

## ✨ Fitur Utama

### 🎯 Dashboard Interaktif

- **Statistik Real-time**: Penjualan harian, mingguan, dan bulanan
- **Grafik Penjualan**: Visualisasi data 7 hari terakhir
- **Product Tracking**: Monitor produk terlaris
- **Stok Alert**: Notifikasi produk dengan stok menipis

### 👥 Role-Based Access Control

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

- Point of Sale (POS) interface
- Keranjang belanja interaktif
- Export transaksi ke Excel
- Riwayat transaksi lengkap
- Filter berdasarkan tanggal

### 🏷️ Manajemen Kategori (Owner Only)

- CRUD kategori produk
- Deskripsi detail kategori

### 👨‍💼 Manajemen Pegawai (Owner Only)

- Tambah/edit/hapus pegawai
- Informasi kontak lengkap
- Manajemen role

## 🛠️ Tech Stack

### Backend

- **Laravel 12** - PHP Framework
- **PHP 8.2+** - Server-side scripting
- **MySQL** - Database management

### Frontend

- **Blade Templates** - Templating engine
- **Vanilla CSS** - Custom styling
- **Font Awesome 6** - Icon library
- **Chart.js** - Data visualization

### Additional Libraries

- **Maatwebsite/Laravel-Excel** - Export to Excel
- **Laravel Tinker** - REPL for Laravel

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (for asset compilation)
- Web Server (Apache/Nginx)

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/FajrilMaulid/web-coffe-shop.git
cd web-coffe-shop
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffe_dewek_web
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations & Seeders

```bash
# Create database tables
php artisan migrate

# Seed sample data
php artisan db:seed
```

### 6. Create Storage Link

```bash
php artisan storage:link
```

### 7. Build Assets (Optional)

```bash
npm run build
```

### 8. Run Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

## 👤 Default User Credentials

### Owner Account

- **Email**: `owner@example.com`
- **Password**: `password`

### Employee Account

- **Email**: `pegawai@example.com`
- **Password**: `password`

## 📖 Usage Guide

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

## 📂 Project Structure

```
coffe_dewek_web/
├── app/
│   ├── Http/
│   │   └── Controllers/      # Application controllers
│   ├── Models/               # Eloquent models
│   └── Middleware/           # Custom middleware
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/
│   ├── css/                  # Compiled CSS
│   ├── js/                   # JavaScript files
│   └── storage/              # Public storage (symlink)
├── resources/
│   └── views/                # Blade templates
│       ├── auth/
│       ├── dashboard/
│       ├── products/
│       ├── transactions/
│       ├── categories/
│       ├── users/
│       └── layouts/
└── routes/
    └── web.php               # Web routes
```

## 🎨 Features Showcase

### Modern UI/UX

- Responsive design untuk semua device
- Dark sidebar dengan gradient styling
- Interactive hover effects
- Smooth transitions dan animations
- Clean dan minimalist interface

### Security Features

- Role-based middleware
- CSRF protection
- Secure authentication
- Backend validation untuk role-specific actions

### Performance

- Optimized database queries
- Efficient asset loading
- Client-side search filtering
- Smooth page transitions

## 🔒 Security

- **Authentication**: Laravel's built-in authentication system
- **Authorization**: Role-based access control dengan middleware
- **CSRF Protection**: Token validation pada semua form
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Blade template escaping

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Developer

**Fajril Maulid**

- GitHub: [@FajrilMaulid](https://github.com/FajrilMaulid)

## 🙏 Acknowledgments

- Laravel Framework
- Font Awesome Icons
- Chart.js for data visualization
- Maatwebsite/Laravel-Excel for export functionality

---

<p align="center">Made with ☕ and ❤️</p>
