# 🌐 Panduan Lengkap Deploy API Siswa ke Hosting Online

Proyek API ini telah dikonfigurasi agar **siap di-deploy ke berbagai layanan hosting online** (cPanel / Shared Hosting, VPS, maupun Platform Cloud PaaS seperti Railway / Render).

---

## 🛠️ Ringkasan Konfigurasi yang Sudah Disediakan
1. **Root `.htaccess` Siap Pakai:** Otomatis mengarahkan request ke folder `/public` dan memblokir akses ke file sensitif (`.env`, `.git`, composer).
2. **Auto Trust Proxies (HTTPS):** Mendukung SSL / Reverse Proxy (Cloudflare, cPanel SSL, PaaS) agar tidak terjadi mixed content error.
3. **Frontend Auto-Detect Domain:** Starter kit di `public/starter-kit/app.js` otomatis mendeteksi domain server online (`window.location.origin/api`).
4. **Helper `/setup-database`:** Inisialisasi tabel & seeder 12 siswa via browser tanpa perlu akses terminal SSH.
5. **Auto-Create SQLite:** File database SQLite otomatis dibuat jika belum ada di server.
6. **Procfile PaaS:** Siap di-deploy dengan 1-klik di Railway, Render, atau Koyeb.

---

## Opsi 1: Deploy ke Shared Hosting (cPanel / Niagahoster / Hostinger / DomaiNesia)

### Langkah 1: Upload File ke Hosting
1. Masuk ke **cPanel** -> **File Manager**.
2. Masuk ke folder `public_html`.
3. Upload seluruh file proyek ini ke dalam `public_html` (termasuk folder `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, `storage`, `vendor`, serta file `.htaccess`).
4. Pastikan file `.htaccess` di root `public_html` ikut terupload. (Aktifkan opsi *Show Hidden Files* di File Manager).

### Langkah 2: Setup File `.env`
1. Buat atau salin file `.env.example` menjadi `.env` di folder utama `public_html`.
2. Edit file `.env`:
   ```env
   APP_NAME="API Siswa"
   APP_ENV=production
   APP_KEY=base64:XG8d2W4Hj... (isi dengan APP_KEY dari local atau generate baru)
   APP_DEBUG=false
   APP_URL=https://domain-anda.com

   # OPSI A: Menggunakan SQLite (Paling Mudah, Tanpa Setup Database di cPanel)
   DB_CONNECTION=sqlite

   # OPSI B: Menggunakan MySQL cPanel (Opsional)
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=nama_db_cpanel
   # DB_USERNAME=nama_user_cpanel
   # DB_PASSWORD=password_db_cpanel
   ```

### Langkah 3: Beri Izin Akses Folder (Permissions)
Di cPanel File Manager, klik kanan dan ubah Permission:
* Folder `storage` dan semua subfoldernya -> **`775`** atau **`777`**
* Folder `bootstrap/cache` -> **`775`** atau **`777`**
* Folder `database` (jika pakai SQLite) -> **`775`** atau **`777`**

### Langkah 4: Inisialisasi Database (Tanpa SSH)
Buka browser dan akses URL helper berikut:
```text
https://domain-anda.com/setup-database
```
Server akan otomatis menjalankan migrasi dan mengisi 12 data siswa. Anda akan melihat pesan:
```json
{
  "success": true,
  "message": "Database berhasil dimigrasi dan 12 data siswa berhasil di-seed ke hosting!"
}
```

---

## Opsi 2: Deploy ke Platform Cloud (Railway / Render.com)

Karena proyek ini sudah terhubung ke GitHub `kckdevelop/pembelajaran-api`, Anda bisa deploy secara otomatis:

### Langkah di Render.com / Railway:
1. Login ke [render.com](https://render.com) atau [railway.app](https://railway.app).
2. Pilih **New** -> **Web Service**.
3. Hubungkan ke repositori GitHub: `kckdevelop/pembelajaran-api`.
4. Sistem akan otomatis mendeteksi PHP dan file `Procfile`.
5. Masukkan **Environment Variables**:
   * `APP_KEY` = (salin dari file `.env` lokal Anda)
   * `APP_ENV` = `production`
   * `APP_DEBUG` = `false`
   * `APP_URL` = `https://<nama-app>.onrender.com`
   * `DB_CONNECTION` = `sqlite`
6. Klik **Deploy**.
7. Setelah selesai dideploy, buka `https://<nama-app>.onrender.com/setup-database` sekali untuk mengisi data awal siswa.

---

## Opsi 3: Deploy ke VPS (Ubuntu / Nginx / Apache)

Jika Anda menggunakan VPS Linux:
```bash
# 1. Clone repository
git clone https://github.com/kckdevelop/pembelajaran-api.git /var/www/api-siswa
cd /var/www/api-siswa

# 2. Install dependensi
composer install --optimize-autoloader --no-dev

# 3. Setup .env & Key
cp .env.example .env
php artisan key:generate

# 4. Beri permission
sudo chown -R www-data:www-data storage bootstrap/cache database
sudo chmod -R 775 storage bootstrap/cache database

# 5. Jalankan migrasi & data seeder
php artisan migrate --force --seed

# 6. Optimize konfigurasi
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ Menguji Hasil Deploy
Setelah selesai, Anda dapat langsung menguji:
* **Halaman Dokumentasi & Live Tester:** `https://domain-anda.com/`
* **Endpoint API Data Siswa:** `https://domain-anda.com/api/siswas`
* **Frontend Starter Kit Praktikum:** `https://domain-anda.com/starter-kit/index.html`
