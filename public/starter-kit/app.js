/**
 * PRAKTIKUM API SISWA: File JavaScript Utama (app.js)
 * 
 * Materi yang dipelajari:
 * 1. Menghubungi REST API menggunakan fetch() & async/await
 * 2. Mengolah data format JSON dari response server
 * 3. Manipulasi DOM dinamis (rendering kartu data siswa)
 * 4. Filter & Search via Query Parameters API
 * 5. Mengirim data baru dengan method POST
 * 6. Menghapus data dengan method DELETE
 */

// 1. Tentukan Base URL API Server Laravel
const API_BASE_URL = 'http://127.0.0.1:8000/api';

// 2. Seleksi Elemen-elemen DOM
const containerSiswa = document.getElementById('studentsContainer');
const loadingStatus = document.getElementById('loadingStatus');
const inputCari = document.getElementById('inputCari');
const selectJurusan = document.getElementById('selectJurusan');
const selectGender = document.getElementById('selectGender');
const btnReset = document.getElementById('btnReset');

// Elemen Statistik
const statTotal = document.getElementById('statTotal');
const statLaki = document.getElementById('statLaki');
const statPerempuan = document.getElementById('statPerempuan');

// Elemen Modal Tambah Siswa
const modalTambah = document.getElementById('modalTambah');
const btnBukaModal = document.getElementById('btnBukaModal');
const btnTutupModal = document.getElementById('btnTutupModal');
const btnBatal = document.getElementById('btnBatal');
const formTambahSiswa = document.getElementById('formTambahSiswa');

/**
 * LANGKAH 1: Mengambil & Menampilkan Data Siswa (GET /api/siswas)
 */
async function ambilDataSiswa() {
    try {
        loadingStatus.style.display = 'block';
        loadingStatus.className = 'alert info';
        loadingStatus.textContent = 'Sedang memuat data dari API server...';

        // Susun parameter URL berdasarkan filter yang dipilih pengguna
        const params = new URLSearchParams();
        params.append('all', 'true'); // Ambil seluruh data tanpa potongan halaman

        if (inputCari.value.trim() !== '') {
            params.append('search', inputCari.value.trim());
        }
        if (selectJurusan.value !== '') {
            params.append('jurusan', selectJurusan.value);
        }
        if (selectGender.value !== '') {
            params.append('jenis_kelamin', selectGender.value);
        }

        // Panggil endpoint menggunakan fetch()
        const urlEndpoint = `${API_BASE_URL}/siswas?${params.toString()}`;
        const response = await fetch(urlEndpoint);

        if (!response.ok) {
            throw new Error(`Gagal menghubungi API. Status HTTP: ${response.status}`);
        }

        const hasilJson = await response.json();

        // Sembunyikan status loading
        loadingStatus.style.display = 'none';

        // Render data siswa ke dalam antarmuka web
        tampilkanDataSiswa(hasilJson.data);
    } catch (error) {
        console.error('Error saat fetch data siswa:', error);
        loadingStatus.style.display = 'block';
        loadingStatus.className = 'alert danger';
        loadingStatus.textContent = `Error: ${error.message}. Pastikan server Laravel sedang berjalan (php artisan serve).`;
    }
}

/**
 * LANGKAH 2: Render Kartu Siswa ke DOM
 */
function tampilkanDataSiswa(daftarSiswa) {
    containerSiswa.innerHTML = '';

    if (!daftarSiswa || daftarSiswa.length === 0) {
        containerSiswa.innerHTML = `
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #64748b;">
                <h3>Tidak ada data siswa yang cocok</h3>
                <p>Coba ubah kata kunci pencarian atau reset filter.</p>
            </div>
        `;
        return;
    }

    daftarSiswa.forEach(siswa => {
        // Tentukan foto default jika foto kosong
        const avatarUrl = siswa.foto || `https://ui-avatars.com/api/?name=${encodeURIComponent(siswa.nama)}&background=4f46e5&color=fff`;

        const card = document.createElement('div');
        card.className = 'student-card';
        card.innerHTML = `
            <div class="card-top">
                <img src="${avatarUrl}" alt="${siswa.nama}" class="card-avatar" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(siswa.nama)}'">
                <div>
                    <h3>${siswa.nama}</h3>
                    <span class="nis-badge">NIS: ${siswa.nis}</span>
                </div>
            </div>
            <div class="card-body">
                <div><strong>Kelas:</strong> ${siswa.kelas}</div>
                <div><strong>TTL:</strong> ${siswa.tempat_lahir}, ${siswa.tanggal_lahir}</div>
                <div><strong>Alamat:</strong> ${siswa.alamat}</div>
                <div><strong>Kontak:</strong> ${siswa.no_telp || '-'} | ${siswa.email || '-'}</div>
            </div>
            <div class="card-footer">
                <span class="jurusan-tag">${siswa.jurusan}</span>
                <button class="btn btn-outline btn-sm" onclick="hapusSiswa(${siswa.id}, '${siswa.nama}')" style="color: #ef4444; border-color: #fca5a5;">
                    Hapus
                </button>
            </div>
        `;

        containerSiswa.appendChild(card);
    });
}

/**
 * LANGKAH 3: Mengambil Data Statistik (GET /api/siswas/statistik)
 */
async function ambilStatistik() {
    try {
        const response = await fetch(`${API_BASE_URL}/siswas/statistik`);
        const json = await response.json();

        if (json.success) {
            statTotal.textContent = json.data.total_siswa;
            statLaki.textContent = json.data.jenis_kelamin.laki_laki;
            statPerempuan.textContent = json.data.jenis_kelamin.perempuan;
        }
    } catch (error) {
        console.warn('Gagal memuat statistik:', error);
    }
}

/**
 * LANGKAH 4: Mengirim Data Siswa Baru (POST /api/siswas)
 */
async function tambahSiswa(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    
    // Konversi FormData ke objek JavaScript
    const payload = Object.fromEntries(formData.entries());

    try {
        const btnSimpan = document.getElementById('btnSimpan');
        btnSimpan.disabled = true;
        btnSimpan.textContent = 'Menyimpan...';

        const response = await fetch(`${API_BASE_URL}/siswas`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const hasil = await response.json();

        if (response.status === 201 && hasil.success) {
            alert('Sukses! Data siswa berhasil ditambahkan.');
            form.reset();
            modalTambah.classList.remove('active');
            
            // Muat ulang data terbaru dan statistik
            ambilDataSiswa();
            ambilStatistik();
        } else if (response.status === 422) {
            // Validasi gagal dari server
            const pesanError = Object.values(hasil.errors).flat().join('\n');
            alert(`Validasi Gagal:\n${pesanError}`);
        } else {
            alert(`Gagal menyimpan: ${hasil.message || 'Terjadi kesalahan sistem'}`);
        }
    } catch (error) {
        alert(`Error: ${error.message}`);
    } finally {
        const btnSimpan = document.getElementById('btnSimpan');
        btnSimpan.disabled = false;
        btnSimpan.textContent = 'Simpan Siswa';
    }
}

/**
 * LANGKAH 5: Menghapus Data Siswa (DELETE /api/siswas/{id})
 */
async function hapusSiswa(id, nama) {
    const konfirmasi = confirm(`Apakah Anda yakin ingin menghapus data siswa "${nama}"?`);
    if (!konfirmasi) return;

    try {
        const response = await fetch(`${API_BASE_URL}/siswas/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json'
            }
        });

        const hasil = await response.json();

        if (response.ok && hasil.success) {
            alert(`Data siswa "${nama}" berhasil dihapus.`);
            ambilDataSiswa();
            ambilStatistik();
        } else {
            alert(`Gagal menghapus: ${hasil.message}`);
        }
    } catch (error) {
        alert(`Error saat menghapus siswa: ${error.message}`);
    }
}

// Event Listeners untuk Filter & Search
inputCari.addEventListener('keyup', (e) => {
    if (e.key === 'Enter') ambilDataSiswa();
});
selectJurusan.addEventListener('change', ambilDataSiswa);
selectGender.addEventListener('change', ambilDataSiswa);

btnReset.addEventListener('click', () => {
    inputCari.value = '';
    selectJurusan.value = '';
    selectGender.value = '';
    ambilDataSiswa();
});

// Modal Events
btnBukaModal.addEventListener('click', () => modalTambah.classList.add('active'));
btnTutupModal.addEventListener('click', () => modalTambah.classList.remove('active'));
btnBatal.addEventListener('click', () => modalTambah.classList.remove('active'));
formTambahSiswa.addEventListener('submit', tambahSiswa);

// Inisialisasi awal saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', () => {
    ambilDataSiswa();
    ambilStatistik();
});
