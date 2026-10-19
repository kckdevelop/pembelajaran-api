# JOBSHEET PRAKTIKUM PEMBELAJARAN RESTful API
## Mata Pelajaran: Pemrograman Web & Perangkat Bergerak (PWPB)
**Tingkat / Program Keahlian:** SMK / Rekayasa Perangkat Lunak (RPL) & Sistem Informasi Jaringan dan Aplikasi (SIJA)  
**Topik Praktikum:** Konsumsi & Integrasi RESTful API Menggunakan JavaScript Modern (Fetch API)  
**Alokasi Waktu:** 4 – 8 Jam Pelajaran (JP)

---

## 1. Capaian & Tujuan Pembelajaran

Setelah menyelesaikan jobsheet ini, peserta didik diharapkan mampu:
1. **Memahami Konsep Dasar API:** Menjelaskan cara kerja arsitektur *Client-Server*, protokol HTTP/HTTPS, dan pertukaran data berbasis format **JSON** (*JavaScript Object Notation*).
2. **Menguasai HTTP Methods & Status Codes:** Memahami perbedaan method `GET`, `POST`, `PUT/PATCH`, `DELETE` serta kode status HTTP (`200 OK`, `201 Created`, `404 Not Found`, `422 Unprocessable Entity`).
3. **Menguji Endpoint API:** Melakukan pengujian request dan response API menggunakan Web Browser, cURL, Postman, atau ekstensi VS Code (*Thunder Client / REST Client*).
4. **Mengimplementasikan Fetch API:** Memanfaatkan fungsi `fetch()`, `async/await`, dan `JSON.stringify()` / `response.json()` dalam proyek website.
5. **Manipulasi DOM Dinamis:** Merender data array of objects dari server ke dalam bentuk elemen kartu (*cards*) atau tabel HTML interaktif.
6. **Membangun Fitur Pencarian & Filter:** Mengirimkan *query parameters* dari input form ke server API secara dinamis.

---

## 2. Landasan Teori Singkat

### A. Apa itu RESTful API?
**API** (*Application Programming Interface*) adalah jembatan komunikasi antara aplikasi frontend (tampilan web pengguna) dengan backend/database server. REST (*Representational State Transfer*) menggunakan standar protokol HTTP untuk membaca dan memanipulasi data:
- `GET`: Mengambil data dari server (hanya membaca, tidak mengubah isi database).
- `POST`: Mengirim data baru ke server untuk disimpan ke database.
- `PUT / PATCH`: Memperbarui data yang sudah ada di server.
- `DELETE`: Menghapus data dari server.

### B. Format Data JSON
JSON adalah format standar pertukaran data yang ringan dan mudah dibaca manusia maupun mesin. Contoh data satu siswa:
```json
{
  "id": 1,
  "nis": "102301001",
  "nama": "Ahmad Fauzi Rahman",
  "jenis_kelamin": "L",
  "tempat_lahir": "Bandung",
  "tanggal_lahir": "2007-04-12",
  "agama": "Islam",
  "alamat": "Jl. Merdeka No. 45, Coblong, Bandung",
  "no_telp": "081234567891",
  "email": "ahmad.fauzi@smk.sch.id",
  "kelas": "XI-RPL-1",
  "jurusan": "Rekayasa Perangkat Lunak",
  "tahun_masuk": "2023",
  "status": "aktif",
  "foto": "https://..."
}
```

---

## 3. Spesifikasi API Server Siswa

API ini berjalan di server lokal Laravel 12 dan **tidak memerlukan token otentikasi (tanpa auth)** sehingga sangat ramah bagi pemula.

* **Base URL:** `http://127.0.0.1:8000/api`
* **CORS Support:** Aktif (`*` - Semua domain & localhost diizinkan).

### Tabel Daftar Endpoint:

| No | HTTP Method | Endpoint | Keterangan & Parameter | Status Sukses |
|---|---|---|---|---|
| 1 | `GET` | `/api/siswas` | Mengambil daftar siswa. Parameter opsional: `?search=nama`, `?jurusan=RPL`, `?kelas=XI-RPL-1`, `?jenis_kelamin=L/P`, `?all=true` | `200 OK` |
| 2 | `GET` | `/api/siswas/{id}` | Mengambil detail siswa berdasarkan `id` atau `nis` | `200 OK` (404 jika tidak ada) |
| 3 | `POST` | `/api/siswas` | Menambahkan siswa baru. Body format: `application/json` | `201 Created` (422 jika validasi gagal) |
| 4 | `PUT` | `/api/siswas/{id}` | Memperbarui data siswa berdasarkan ID | `200 OK` |
| 5 | `DELETE` | `/api/siswas/{id}` | Menghapus siswa berdasarkan ID | `200 OK` |
| 6 | `GET` | `/api/siswas/statistik` | Mengambil rekap statistik (total siswa, gender, jurusan, kelas) | `200 OK` |

---

## 4. Langkah-Langkah Praktikum Terbimbing

### Langkah 1: Menjalankan Server API Laravel
1. Buka aplikasi Terminal / Command Prompt pada komputer Anda.
2. Masuk ke direktori proyek API:
   ```bash
   cd e:\PEMBELAJARAN-API
   ```
3. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```
4. Pastikan muncul tulisan:
   ```text
   INFO  Server running on [http://127.0.0.1:8000].
   ```
5. Buka browser dan akses: `http://127.0.0.1:8000/api/siswas`  
   *Jika muncul kumpulan data siswa dalam format JSON, maka server API siap digunakan!*

---

### Langkah 2: Menguji API via Extension / Browser
Uji beberapa skenario berikut di browser Anda:
1. **Mengambil semua siswa tanpa pagination:**  
   `http://127.0.0.1:8000/api/siswas?all=true`
2. **Mencari siswa bernama "Aisyah":**  
   `http://127.0.0.1:8000/api/siswas?search=Aisyah`
3. **Memfilter siswa jurusan Rekayasa Perangkat Lunak:**  
   `http://127.0.0.1:8000/api/siswas?jurusan=Rekayasa`
4. **Melihat statistik dashboard:**  
   `http://127.0.0.1:8000/api/siswas/statistik`

---

### Langkah 3: Menyiapkan Proyek Web Frontend Siswa
Buat folder baru untuk proyek web siswa (misal di komputer Anda atau gunakan folder `public/starter-kit/`).  
Struktur file minimal:
```text
proyek-web-siswa/
├── index.html
├── style.css
└── app.js
```

Buat file `index.html`:
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa SMK - Konsumsi API</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Portal Data Siswa SMK</h1>
        
        <!-- Filter Bar -->
        <div class="filter-box">
            <input type="text" id="inputCari" placeholder="Ketik nama siswa..." />
            <select id="pilihJurusan">
                <option value="">Semua Jurusan</option>
                <option value="Rekayasa Perangkat Lunak">RPL</option>
                <option value="Teknik Komputer dan Jaringan">TKJ</option>
                <option value="Desain Komunikasi Visual">DKV</option>
            </select>
            <button id="btnMuat">Terapkan Filter</button>
        </div>

        <div id="statusTeks">Memuat data...</div>

        <!-- Wadah Kartu Siswa -->
        <div id="wadahSiswa" class="grid-kartu"></div>
    </div>

    <script src="app.js"></script>
</body>
</html>
```

---

### Langkah 4: Menulis Kode JavaScript Fetch API (`app.js`)
Ketik kode berikut pada `app.js`:

```javascript
// 1. Definisikan URL API Server
const URL_API = 'http://127.0.0.1:8000/api/siswas';

// 2. Ambil referensi elemen HTML
const wadahSiswa = document.getElementById('wadahSiswa');
const statusTeks = document.getElementById('statusTeks');
const inputCari = document.getElementById('inputCari');
const pilihJurusan = document.getElementById('pilihJurusan');
const btnMuat = document.getElementById('btnMuat');

// 3. Fungsi Asinkron untuk mengambil data dari server
async function loadSiswa() {
    try {
        statusTeks.textContent = 'Menghubungi server API...';
        
        // Buat parameter query
        const url = new URL(URL_API);
        url.searchParams.append('all', 'true');
        
        if (inputCari.value) {
            url.searchParams.append('search', inputCari.value);
        }
        if (pilihJurusan.value) {
            url.searchParams.append('jurusan', pilihJurusan.value);
        }

        // Panggil fetch()
        const respon = await fetch(url.toString());
        
        if (!respon.ok) {
            throw new Error(`HTTP Error status: ${respon.status}`);
        }

        const dataJson = await respon.json();
        
        statusTeks.textContent = `Ditemukan ${dataJson.data.length} siswa.`;
        
        // Tampilkan kartu ke DOM
        renderKartu(dataJson.data);
    } catch (error) {
        statusTeks.textContent = `Gagal memuat: ${error.message}`;
        console.error(error);
    }
}

// 4. Fungsi me-render data siswa ke dalam kartu HTML
function renderKartu(daftar) {
    wadahSiswa.innerHTML = '';

    if (daftar.length === 0) {
        wadahSiswa.innerHTML = '<p>Tidak ada data siswa ditemukan.</p>';
        return;
    }

    daftar.forEach(siswa => {
        const kartu = document.createElement('div');
        kartu.className = 'kartu-siswa';
        kartu.innerHTML = `
            <img src="${siswa.foto}" alt="${siswa.nama}" class="foto-siswa" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(siswa.nama)}'">
            <h3>${siswa.nama}</h3>
            <p><strong>NIS:</strong> ${siswa.nis}</p>
            <p><strong>Kelas:</strong> ${siswa.kelas}</p>
            <p><strong>Jurusan:</strong> ${siswa.jurusan}</p>
            <p><strong>Kota Asal:</strong> ${siswa.tempat_lahir}</p>
        `;
        wadahSiswa.appendChild(kartu);
    });
}

// 5. Jalankan fungsi saat tombol diklik atau saat halaman dibuka
btnMuat.addEventListener('click', loadSiswa);
document.addEventListener('DOMContentLoaded', loadSiswa);
```

---

### Langkah 5: Mengirim Data Siswa Baru (POST Method)
Jelaskan kepada siswa cara mengirim data form menggunakan `fetch()` dengan method `POST`:
```javascript
async function simpanSiswaBaru(dataBaru) {
    try {
        const respon = await fetch('http://127.0.0.1:8000/api/siswas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataBaru)
        });

        const hasil = await respon.json();

        if (respon.status === 201) {
            alert('Berhasil menambah siswa: ' + hasil.data.nama);
            loadSiswa(); // Refresh tampilan kartu
        } else if (respon.status === 422) {
            alert('Validasi Gagal: ' + JSON.stringify(hasil.errors));
        }
    } catch (error) {
        alert('Terjadi kesalahan jaringan: ' + error.message);
    }
}
```

---

## 5. Praktikum Mandiri (Tantangan Siswa)

Kerjakan tugas mandiri berjenjang berikut pada proyek website Anda masing-masing:

### 🌟 Level 1 (Tingkat Dasar):
1. Tambahkan indikator status siswa berupa badge warna:
   - Jika `status === 'aktif'`, warna hijau.
   - Jika `status === 'lulus'`, warna biru.
   - Jika `status === 'tidak_aktif'`, warna abu-abu.
2. Tambahkan pencarian instan (*live search*) sehingga setiap kali siswa mengetik huruf di kolom pencarian, data otomatis terfilter tanpa perlu menekan tombol submit.

### 🚀 Level 2 (Tingkat Menengah):
1. **Modal Popup Detail Siswa:**  
   Ketika salah satu kartu siswa diklik, tampilkan jendela modal pop-up yang memanggil endpoint `GET /api/siswas/{id}` untuk menampilkan rincian alamat lengkap, tanggal lahir, agama, nomor telepon, dan email siswa.
2. **Tombol Hapus Siswa:**  
   Tambahkan tombol **Hapus** pada setiap kartu siswa yang mengirimkan permintaan `DELETE /api/siswas/{id}` setelah pengguna memberikan konfirmasi dialog (`confirm()`).

### 🏆 Level 3 (Tingkat Mahir):
1. **Widget Statistik Dashboard:**  
   Konsumsi endpoint `GET /api/siswas/statistik` lalu buat 3 kartu ringkasan di atas halaman:
   - Total Keseluruhan Siswa
   - Jumlah Laki-laki vs Perempuan
   - Jumlah Siswa per Jurusan
2. **Formulir Tambah Siswa:**  
   Buat modal/form input data lengkap untuk menambahkan siswa baru ke server API dengan validasi format tanggal dan nomor NIS.

---

## 6. Rubrik Penilaian Praktikum

| No | Komponen Penilaian | Indikator Keberhasilan | Bobot Skor |
|---|---|---|---|
| 1 | **Konektivitas API Server** | Mampu menjalankan server Laravel 12 dan menguji endpoint via browser/tester | 15% |
| 2 | **Implementasi Fetch API** | Berhasil memanggil `GET /api/siswas` menggunakan `async/await` dengan penanganan error (`try-catch`) yang baik | 25% |
| 3 | **Manipulasi DOM & Tampilan** | Menampilkan kartu data siswa secara rapi, responsif, dan menyertakan foto avatar | 25% |
| 4 | **Filter & Pencarian** | Fitur filter jurusan dan live search berfungsi mengirim parameter ke API | 15% |
| 5 | **Praktikum Mandiri (Tantangan)** | Mampu menyelesaikan minimal 1 tantangan (Modal detail, Hapus, Tambah, atau Statistik) | 20% |
| **Total** | | | **100%** |

---

## 7. Lembar Refleksi Siswa

Jawablah pertanyaan berikut pada buku catatan / laporan praktikum Anda:
1. Apa keuntungan memisahkan aplikasi menjadi Frontend (HTML/JS) dan Backend API (Laravel)?
2. Mengapa kita perlu menggunakan `JSON.stringify()` saat mengirim data pada method `POST`, dan sebaliknya menggunakan `response.json()` saat menerima respons dari server?
3. Apa perbedaan fungsi status HTTP `200`, `201`, `404`, dan `422`?
4. Kendala apa saja yang Anda temui selama menghubungkan website dengan API lokal, dan bagaimana cara Anda mengatasinya?
