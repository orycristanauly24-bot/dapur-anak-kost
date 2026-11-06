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
        Schema::create('recipe_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade'); // Relasi ke resep
            $table->foreignId('user_id')->constrained()->onDelete('cascade');    // Relasi ke user yang komen
            $table->text('comment');                                             // Isi komentar
            $table->unsignedTinyInteger('rating')->default(5);                   // Rating bintang (1-5)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_comments');
    }
};