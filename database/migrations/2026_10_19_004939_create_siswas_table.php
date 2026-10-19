<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 10)->unique()->comment('Nomor Induk Siswa');
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['L', 'P'])->comment('L = Laki-laki, P = Perempuan');
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('agama', 30);
            $table->text('alamat');
            $table->string('no_telp', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('kelas', 10)->comment('Contoh: X-TKJ-1, XI-RPL-2');
            $table->string('jurusan', 100)->comment('Contoh: Teknik Komputer Jaringan');
            $table->string('tahun_masuk', 4);
            $table->enum('status', ['aktif', 'tidak_aktif', 'lulus', 'keluar'])->default('aktif');
            $table->string('foto', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
