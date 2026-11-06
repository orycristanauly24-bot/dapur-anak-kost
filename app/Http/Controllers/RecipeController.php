<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->q;
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%");
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
            })
            ->latest()
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('welcome', compact('recipes', 'categories'));
    }

    public function show(Recipe $recipe)
    {
        $recipe->load('category');
        return view('recipes.show', compact('recipe'));
    }

    public function createUserRecipe()
    {
        $categories = Category::orderBy('name')->get();
        return view('recipes.create', compact('categories'));
    }

    public function storeUserRecipe(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('recipes', 'public');
        } else {
            unset($data['image']);
        }

        Recipe::create($data);

        return redirect()->route('home')->with('success', 'Resep berhasil dikirim.');
    }

    // --- PROTEKSI ADMIN & SUPER ADMIN ---

    public function adminIndex()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Maaf, kamu tidak memiliki akses.');
        }

        $recipes = Recipe::with('category')->latest()->get();
        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Maaf, kamu tidak memiliki akses.');
        }

        $categories = Category::orderBy('name')->get();
        return view('admin.recipes.form', ['recipe' => new Recipe(), 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Maaf, kamu tidak memiliki akses.');
        }

        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('recipes', 'public');
        } else {
            unset($data['image']);
        }

        Recipe::create($data);

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil ditambahkan.');
    }

    public function edit(Recipe $recipe)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Maaf, kamu tidak memiliki akses.');
        }

        $categories = Category::orderBy('name')->get();
        return view('admin.recipes.form', compact('recipe', 'categories'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Maaf, kamu tidak memiliki akses.');
        }

        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $data['image'] = $request->file('image')->store('recipes', 'public');
        } else {
            unset($data['image']);
        }

        $recipe->update($data);

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil diperbarui.');
    }

    public function destroy(Recipe $recipe)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Maaf, kamu tidak memiliki akses.');
        }

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'category_id'       => ['required', 'exists:categories,id'],
            'title'             => ['required', 'string', 'max:120'],
            'description'       => ['required', 'string', 'max:500'],
            'ingredients_text'  => ['required', 'string'],
            'instructions_text' => ['required', 'string'],
            'cooking_time'      => ['required', 'integer', 'min:1', 'max:600'],
            'estimated_cost'    => ['required', 'integer', 'min:0'],
            'image'             => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['ingredients'] = array_values(array_filter(array_map('trim', explode("\n", $request->ingredients_text))));
        $validated['instructions'] = array_values(array_filter(array_map('trim', explode("\n", $request->instructions_text))));

        unset($validated['ingredients_text'], $validated['instructions_text']);

        return $validated;
    }
}