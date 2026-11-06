@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Kirim Resep</h1>

    <p class="text-muted">
        Bagikan resep masakanmu. Resep akan ditinjau admin sebelum ditampilkan.
    </p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data yang kamu masukkan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('recipes.user.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Nama Resep</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="{{ old('title') }}"
                required
                maxlength="120"
            >
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select
                id="category_id"
                name="category_id"
                class="form-select"
                required
            >
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea
                id="description"
                name="description"
                class="form-control"
                rows="3"
                maxlength="500"
                required
            >{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="ingredients_text" class="form-label">
                Bahan-bahan
            </label>
            <textarea
                id="ingredients_text"
                name="ingredients_text"
                class="form-control"
                rows="5"
                placeholder="Satu bahan per baris"
                required
            >{{ old('ingredients_text') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="instructions_text" class="form-label">
                Langkah Memasak
            </label>
            <textarea
                id="instructions_text"
                name="instructions_text"
                class="form-control"
                rows="6"
                placeholder="Satu langkah per baris"
                required
            >{{ old('instructions_text') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="cooking_time" class="form-label">
                Waktu Memasak (menit)
            </label>
            <input
                type="number"
                id="cooking_time"
                name="cooking_time"
                class="form-control"
                value="{{ old('cooking_time') }}"
                min="1"
                max="600"
                required
            >
        </div>

        <div class="mb-3">
            <label for="estimated_cost" class="form-label">
                Perkiraan Biaya (Rp)
            </label>
            <input
                type="number"
                id="estimated_cost"
                name="estimated_cost"
                class="form-control"
                value="{{ old('estimated_cost') }}"
                min="0"
                required
            >
        </div>

        <div class="mb-4">
            <label for="image" class="form-label">Foto Masakan (opsional)</label>
            <input
                type="file"
                id="image"
                name="image"
                class="form-control"
                accept="image/*"
            >
            <small class="text-muted">Maksimal ukuran file 2 MB.</small>
        </div>

        <button type="submit" class="btn btn-primary">
            Kirim Resep
        </button>

        <a href="{{ route('recipes.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection