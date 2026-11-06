<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // 1. Kelola Akun Pengguna
    public function indexUsers()
    {
        $users = User::all();
        return view('superadmin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:user,admin,super_admin'],
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with('success', 'Role pengguna berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Akun pengguna berhasil dihapus.');
    }

    // 2. Kelola Kategori
    public function indexCategories()
    {
        $categories = Category::withCount('recipes')->get();
        return view('superadmin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // 3. Kelola Semua Resep
    public function indexRecipes()
    {
        $recipes = Recipe::with('category', 'user', 'comments')->latest()->get();
        return view('superadmin.recipes.index', compact('recipes'));
    }

    public function destroyRecipe(Recipe $recipe)
    {
        if ($recipe->image && \Storage::disk('public')->exists($recipe->image)) {
            \Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();
        return back()->with('success', 'Resep berhasil dihapus secara permanen.');
    }
}