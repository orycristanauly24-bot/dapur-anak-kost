<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke resep yang dibuat oleh user
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    // Relasi ke komentar/ulasan yang ditulis oleh user
    public function comments(): HasMany
    {
        return $this->hasMany(RecipeComment::class);
    }
}