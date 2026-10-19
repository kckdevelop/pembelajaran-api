# 🎓 API Server Pembelajaran Data Siswa SMK (Laravel 12)

API Server RESTful ini dibuat khusus untuk keperluan pembelajaran siswa dalam memahami cara kerja API, pertukaran data JSON, dan integrasi dengan proyek web frontend (HTML/CSS/JS, React, Vue, Flutter, dll.) **tanpa hambatan autentikasi / token (Public Access)**.

---

## 🌟 Fitur Utama Server API
1. **Laravel 12 Terbaru:** Dibangun menggunakan Laravel 12 dengan struktur API route modern dan performa tinggi.
2. **Tanpa Autentikasi (Public Access):** Siswa dapat langsung melakukan request `GET`, `POST`, `PUT`, `DELETE` tanpa perlu login atau menyertakan Bearer Token.
3. **CORS Otomatis Aktif (`*`):** Dapat diakses dari `localhost:3000`, `localhost:5173`, Live Server VS Code (`127.0.0.1:5500`), maupun file `file://` tanpa kendala CORS.
4. **Data Siswa Lengkap:** Dilengkapi field NIS, Nama, Gender, Tempat & Tanggal Lahir, Agama, Alamat, Kontak, Kelas, Jurusan, Tahun Masuk, Status, dan Foto Avatar.
5. **Fitur Pencarian, Filter & Statistik:** Mendukung filter jurusan, kelas, jenis kelamin, pencarian live, pagination, serta endpoint rekap statistik untuk dashboard.
6. **Live Interactive Tester:** Halaman utama web (`http://127.0.0.1:8000`) langsung menyajikan konsol pengujian interaktif dan preview kartu siswa secara realtime.
7. **Starter Kit Frontend Siap Pakai:** Disediakan template HTML/CSS/JS di folder `public/starter-kit/` sebagai bahan acuan belajar siswa.
8. **Jobsheet Praktikum Terstruktur:** Dilengkapi dokumen modul jobsheet siap cetak/distribusi di `JOBSHEET-PEMBELAJARAN-API.md`.

---

## 🚀 Cara Menjalankan Server API

Pastikan Anda berada di direktori proyek ini pada Terminal / Command Prompt:
```bash
# 1. Jalankan server lokal
php artisan serve
```

Server akan aktif di:
* **Halaman Web & Live API Tester:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
* **Starter Kit Praktikum Frontend Siswa:** [http://127.0.0.1:8000/starter-kit/index.html](http://127.0.0.1:8000/starter-kit/index.html)
* **Base URL API Endpoint:** `http://127.0.0.1:8000/api`

---

## 📑 Spesifikasi Endpoint API

| Method | Endpoint | Fungsi | Contoh Penggunaan |
|---|---|---|---|
| `GET` | `/api` | Informasi & status API server | `/api` |
| `GET` | `/api/siswas` | Mengambil daftar siswa | `/api/siswas?all=true` |
| `GET` | `/api/siswas?search=...` | Mencari siswa berdasarkan nama atau NIS | `/api/siswas?search=Ahmad` |
| `GET` | `/api/siswas?jurusan=...` | Filter berdasarkan jurusan | `/api/siswas?jurusan=Rekayasa` |
| `GET` | `/api/siswas/{id}` | Mengambil detail 1 siswa (bisa pakai ID atau NIS) | `/api/siswas/1` atau `/api/siswas/102301001` |
| `GET` | `/api/siswas/statistik` | Rekap statistik siswa (total, gender, per jurusan) | `/api/siswas/statistik` |
| `POST` | `/api/siswas` | Menambahkan data siswa baru | Body JSON (lihat jobsheet) |
| `PUT` | `/api/siswas/{id}` | Mengubah data siswa | Body JSON |
| `DELETE` | `/api/siswas/{id}` | Menghapus data siswa | `/api/siswas/1` |

---

## 📂 Struktur File Penting

- 📄 [`JOBSHEET-PEMBELAJARAN-API.md`](file:///e:/PEMBELAJARAN-API/JOBSHEET-PEMBELAJARAN-API.md) — Panduan praktikum lengkap untuk siswa & lembar penilaian guru.
- 📁 [`public/starter-kit/`](file:///e:/PEMBELAJARAN-API/public/starter-kit/) — Contoh proyek web frontend implementasi `fetch()` API.
- ⚙️ [`app/Http/Controllers/Api/SiswaController.php`](file:///e:/PEMBELAJARAN-API/app/Http/Controllers/Api/SiswaController.php) — Logika API, filter, validasi & statistik.
- 🗄️ [`database/migrations/2026_10_19_004939_create_siswas_table.php`](file:///e:/PEMBELAJARAN-API/database/migrations/2026_10_19_004939_create_siswas_table.php) — Struktur tabel database siswa.
- 🌱 [`database/seeders/SiswaSeeder.php`](file:///e:/PEMBELAJARAN-API/database/seeders/SiswaSeeder.php) — Data dummy realistis 10 siswa SMK.
- 🌐 [`routes/api.php`](file:///e:/PEMBELAJARAN-API/routes/api.php) — Rute API publik tanpa auth.

---

## 🔄 Reset Data Semula
Jika selama praktikum siswa menambahkan atau menghapus data dan Anda ingin mengembalikan data awal seperti semula:
```bash
php artisan migrate:fresh --seed
```

---

## 🌐 Cara Deploy ke Hosting Online (cPanel / Cloud / VPS)
Proyek ini sudah dilengkapi konfigurasi root `.htaccess`, Reverse Proxy SSL trust, Procfile PaaS, dan URL auto-detect pada Frontend starter kit.

👉 **Lihat panduan langkah demi langkah:** [`PANDUAN-DEPLOY-HOSTING.md`](file:///e:/PEMBELAJARAN-API/PANDUAN-DEPLOY-HOSTING.md)

