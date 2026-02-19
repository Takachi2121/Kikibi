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
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('pesan');
            $table->enum('is_read', ['0', '1'])->default('0');
            $table->enum('jenis_notif', ['0', '1', '2', '3'])->comment('0 = membuat pesanan, 1 = pesanan diproses, 2 = pesanan dikirim, 3 = pesanan selesai')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
