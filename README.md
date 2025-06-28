# 📦 Laravel Project Installation Guide

## ⚙️ Requirements
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & NPM (untuk laravel mix)
- Laravel CLI (opsional)

## 🧪 1. Clone Project

```bash
git clone https://github.com/username/project-laravel.git
cd project-laravel
```

## 📂 2. Install Dependencies

```bash
composer install
npm install
```

## 🔑 3. Setup Environment File

```bash
cp .env.example .env
```

Lalu edit `.env` sesuai konfigurasi lokal:

```env
APP_NAME=MyApp
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=root
DB_PASSWORD=
```

## 🔑 4. Generate Application Key

```bash
php artisan key:generate
```

## 🗄️ 5. Run Migrations (dan seeder jika ada)

```bash
php artisan migrate --seed
```

## 🌐 6. Serve Project Locally

```bash
php artisan serve
```

Buka di browser:
```
http://127.0.0.1:8000
```

## ⚒️ 7. Build Frontend (opsional)

```bash
npm run dev     # saat pengembangan
npm run build   # untuk production
```

## ✅ Selesai!