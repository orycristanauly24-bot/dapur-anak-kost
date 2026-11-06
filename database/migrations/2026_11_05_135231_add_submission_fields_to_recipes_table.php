<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('category_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->string('status')
                ->default('approved')
                ->after('image')
                ->index();

            $table->text('rejection_reason')
                ->nullable()
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['status']);
            $table->dropColumn([
                'user_id',
                'status',
                'rejection_reason',
            ]);
        });
    }
};