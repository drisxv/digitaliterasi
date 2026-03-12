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
        Schema::create('isi_buku', function (Blueprint $table) {
            $table->id();
            $table->integer('id_unik')->unique();
            $table->foreignId('buku_id')->constrained('buku')->references('id')->onDelete('cascade');
            $table->longText('isi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isi_buku');
    }
};
