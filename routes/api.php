<?php

use App\Http\Controllers\Api\SiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Pembelajaran API Siswa (Tanpa Auth)
|--------------------------------------------------------------------------
|
| Endpoint publik untuk pembelajaran siswa mengenai RESTful API.
| Data berupa data siswa lengkap berformat JSON.
|
*/

// Endpoint Sambutan & Informasi API
Route::get('/', function () {
    return response()->json([
        'success' => true,
        'app'     => 'API Server Pembelajaran Data Siswa - SMK',
        'version' => '1.0.0 (Laravel 12)',
        'auth'    => 'Public (Tanpa Autentikasi)',
        'endpoints' => [
            'GET /api/siswas'           => 'Mengambil daftar siswa (bisa filter, search, pagination atau ?all=true)',
            'GET /api/siswas/{id}'      => 'Mengambil detail siswa berdasarkan ID atau NIS',
            'POST /api/siswas'          => 'Menambahkan data siswa baru',
            'PUT /api/siswas/{id}'      => 'Memperbarui data siswa',
            'DELETE /api/siswas/{id}'   => 'Menghapus data siswa',
            'DELETE /api/siswas'        => 'Menghapus SEMUA data siswa sekaligus',
            'GET /api/siswas/statistik' => 'Statistik ringkas data siswa (total, gender, jurusan, kelas)',
        ],
    ]);
});

// Endpoint Statistik (Didefinisikan sebelum apiResource agar tidak dianggap {id})
Route::get('/siswas/statistik', [SiswaController::class, 'statistik']);

// Endpoint Hapus Semua Siswa (Didefinisikan sebelum apiResource agar tidak bentrok)
Route::delete('/siswas/hapus-semua', [SiswaController::class, 'destroyAll']);
Route::delete('/siswas', [SiswaController::class, 'destroyAll']);

// Endpoint CRUD Siswa Lengkap
Route::apiResource('siswas', SiswaController::class);

