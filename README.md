# Dapur Anak Kost — Starter Laravel 12

Website resep sederhana untuk anak kos dengan tema biru teal.

## Fitur
- Halaman utama berisi daftar resep.
- Pencarian resep berdasarkan nama atau bahan.
- Filter kategori.
- Halaman detail resep.
- CRUD resep sederhana melalui halaman `/admin/resep`.
- Upload foto resep (opsional).
- Database MySQL dengan migration dan seeder.

## Persyaratan
- PHP 8.2 atau lebih baru
- Composer
- MySQL/MariaDB (bisa memakai XAMPP)
- Laravel 12

## Cara memasang ke project Laravel 12

Jika belum punya project Laravel 12, buka terminal VS Code dan jalankan:

```bash
composer create-project laravel/laravel dapur-anak-kost "^12.0"
```

Ekstrak ZIP ini. Salin isi folder `dapur-anak-kost-laravel12` ke folder project Laravel yang baru dibuat, dan izinkan file yang sama untuk diganti jika diminta.

Buat database di phpMyAdmin:
1. Jalankan Apache dan MySQL dari XAMPP.
2. Buka `http://localhost/phpmyadmin`.
3. Buat database dengan nama `dapur_anak_kost`.

Atur file `.env` project Laravel:

```env
APP_NAME="Dapur Anak Kost"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dapur_anak_kost
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan:

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Halaman admin resep
Buka `http://127.0.0.1:8000/admin/resep`.

Catatan: halaman admin pada starter ini belum memakai login. Untuk tugas kuliah/demo lokal, jangan dipasang ke hosting publik sebelum menambahkan autentikasi dan pembatasan akses.

## Database SQL
File `database/dapur_anak_kost.sql` dapat diimpor melalui phpMyAdmin jika ingin melihat struktur dan contoh data secara langsung. Untuk menjalankan aplikasi Laravel, lebih disarankan memakai `php artisan migrate --seed` agar struktur database dibuat sesuai migration.
