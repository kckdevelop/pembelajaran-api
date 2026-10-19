<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mencegah error MySQL: 1071 Specified key was too long; max key length is 1000 bytes
        Schema::defaultStringLength(191);

        // Otomatis buat file database SQLite jika belum ada di server hosting
        if (config('database.default') === 'sqlite') {
            $dbPath = config('database.connections.sqlite.database');
            if ($dbPath && !file_exists($dbPath) && $dbPath !== ':memory:') {
                @touch($dbPath);
            }
        }
    }
}
