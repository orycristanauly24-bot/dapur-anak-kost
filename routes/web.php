<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeCommentController;
use App\Http\Controllers\SuperAdminController;

// ==================================
// HALAMAN PUBLIK
// ==================================

Route::get('/', [RecipeController::class, 'index'])
    ->name('home');

Route::get('/resep/{recipe:slug}', [RecipeController::class, 'show'])
    ->name('recipes.show');


// ==================================
// LOGIN, REGISTER, LOGOUT
// ==================================

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==================================
// FITUR USER (WAJIB LOGIN)
// ==================================

Route::middleware('auth')->group(function () {

    // Form pengiriman resep oleh user (Mendukung panggilan route recipes.user.create)
    Route::get('/kirim-resep', [RecipeController::class, 'createUserRecipe'])
        ->name('recipes.user.create');

    // Simpan resep kiriman user
    Route::post('/kirim-resep', [RecipeController::class, 'storeUserRecipe'])
        ->name('recipes.user.store');

    // Fitur Komentar & Rating Resep
    Route::post('/recipes/{recipe}/comments', [RecipeCommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/comments/{comment}', [RecipeCommentController::class, 'destroy'])
        ->name('comments.destroy');

});


// ==================================
// ADMIN DAN SUPER ADMIN (DASHBOARD ADMIN)
// ==================================

Route::middleware(['auth', 'role:admin,super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Daftar resep
        Route::get('/resep', [RecipeController::class, 'adminIndex'])
            ->name('recipes.index');

        // Tambah resep resmi oleh admin
        Route::get('/resep/tambah', [RecipeController::class, 'create'])
            ->name('recipes.create');

        Route::post('/resep', [RecipeController::class, 'store'])
            ->name('recipes.store');

        // Edit resep
        Route::get('/resep/{recipe}/edit', [RecipeController::class, 'edit'])
            ->name('recipes.edit');

        Route::put('/resep/{recipe}', [RecipeController::class, 'update'])
            ->name('recipes.update');

        // Hapus resep
        Route::delete('/resep/{recipe}', [RecipeController::class, 'destroy'])
            ->name('recipes.destroy');
    });


// ==================================
// KHUSUS SUPER ADMIN
// ==================================

Route::middleware(['auth'])->prefix('super-admin')->name('superadmin.')->group(function () {
    // Kelola Akun
    Route::get('/users', [SuperAdminController::class, 'indexUsers'])->name('users.index');
    Route::patch('/users/{user}/role', [SuperAdminController::class, 'updateUserRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('users.destroy');

    // Kelola Kategori
    Route::get('/categories', [SuperAdminController::class, 'indexCategories'])->name('categories.index');
    Route::post('/categories', [SuperAdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [SuperAdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Kelola Semua Resep
    Route::get('/recipes', [SuperAdminController::class, 'indexRecipes'])->name('recipes.index');
    Route::delete('/recipes/{recipe}', [SuperAdminController::class, 'destroyRecipe'])->name('recipes.destroy');
});