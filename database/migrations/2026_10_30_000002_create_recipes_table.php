
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel categories
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            // Informasi resep
            $table->string('title', 120);
            $table->string('slug')->unique();
            $table->string('description', 500);

            // Bahan dan langkah memasak
            $table->json('ingredients');
            $table->json('instructions');

            // Informasi biaya dan waktu memasak
            $table->unsignedSmallInteger('cooking_time');
            $table->unsignedInteger('estimated_cost');

            // Gambar resep
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
