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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('jumlah_jam_kerja');
            $table->integer('tarif');
            $table->integer('tarif_tambahan');
            $table->timestamps();
        });

        Schema::create('tugas_per_pekerja', function (Blueprint $table) {
            $table->id();
            $table->timestamp('jam_mulai');
            $table->timestamp('jam_selesai');
            $table->timestamps();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
        Schema::dropIfExists('tugas_per_pekerja');
    }
};
