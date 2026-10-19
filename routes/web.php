<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs', function () {
    return view('docs');
});

Route::get('/dokumentasi', function () {
    return view('docs');
});


/**
 * Route Helper untuk Shared Hosting / cPanel yang tidak memiliki akses SSH Terminal.
 * Cukup buka URL https://domain-anda.com/setup-database sekali untuk inisialisasi tabel & data seeder.
 */
Route::get('/setup-database', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Database berhasil dimigrasi dan 12 data siswa berhasil di-seed ke hosting!',
            'detail'  => \Illuminate\Support\Facades\Artisan::output() ?: 'Migrate & seed completed.'
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal setup database: ' . $e->getMessage()
        ], 500);
    }
});

