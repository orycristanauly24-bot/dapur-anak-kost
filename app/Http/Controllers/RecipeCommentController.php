<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\RecipeComment;
use Illuminate\Http\Request;

class RecipeCommentController extends Controller
{
    // Simpan komentar dan rating dari user
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:500'],
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        RecipeComment::create([
            'recipe_id' => $recipe->id,
            'user_id'   => auth()->id(),
            'comment'   => $request->comment,
            'rating'    => $request->rating,
        ]);

        return back()->with('success', 'Ulasan dan rating berhasil dikirim.');
    }

    // Hapus komentar (Oleh pemilik komentar atau Super Admin)
    public function destroy(RecipeComment $comment)
    {
        if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'super_admin') {
            abort(403, 'Maaf, kamu tidak memiliki akses untuk menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}