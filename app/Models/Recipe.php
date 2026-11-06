<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'description',
        'ingredients',
        'instructions',
        'cooking_time',
        'estimated_cost',
        'image',
        'status',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'ingredients' => 'array',
            'instructions' => 'array',
            'estimated_cost' => 'integer',
            'cooking_time' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- TAMBAHAN UNTUK KOMENTAR & RATING ---
    public function comments(): HasMany
    {
        return $this->hasMany(RecipeComment::class)->latest();
    }

    public function averageRating()
    {
        return $this->comments()->avg('rating') ?: 0;
    }
}