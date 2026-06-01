# RT Management - Backend API

## Requirements
- PHP >= 8.1
- Composer
- MySQL
- XAMPP / Laragon

## Instalasi

### 1. Clone repository
git clone https://github.com/username/rt-management-api.git
cd rt-management-api

### 2. Install dependencies
composer install

### 3. Setup environment
cp .env.example .env
php artisan key:generate

### 4. Konfigurasi database
Buka file .env, sesuaikan:
DB_DATABASE=rt_management
DB_USERNAME=root
DB_PASSWORD=

### 5. Buat database
Buka phpMyAdmin, buat database baru bernama: rt_management

### 6. Jalankan migration & seeder
php artisan migrate --seed

### 7. Storage link
php artisan storage:link

### 8. Jalankan server
php artisan serve

API berjalan di: http://127.0.0.1:8000