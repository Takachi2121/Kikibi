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
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->text('makna_hadiah');
        });

        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nama_produk');
            $table->text('deskripsi');
            $table->integer('harga');
            $table->integer('umur_min');
            $table->integer('umur_max');
            $table->enum('untuk_gender', ['Pria', 'Wanita', 'Unisex'])->default('Pria');
            $table->text('untuk_momen');
            $table->string('estimasi');
            $table->string('foto_1');
            $table->string('foto_2')->nullable();
            $table->string('foto_3')->nullable();
            $table->string('foto_4')->nullable();
            $table->string('foto_5')->nullable();
        });

        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->integer('jumlah');
            $table->integer('total_harga');
            $table->enum('status', ['Pending', 'Dikirim', 'Selesai'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Produk');
    }
};
