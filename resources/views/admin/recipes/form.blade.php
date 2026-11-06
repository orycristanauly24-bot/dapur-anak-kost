@extends('layouts.app')
@section('title', $recipe->exists ? 'Edit Resep' : 'Tambah Resep')
@section('content')
<section class="container form-section">
    <a class="back-link" href="{{ route('admin.recipes.index') }}">← Kembali ke kelola resep</a>
    <div class="form-card">
        <span class="eyebrow teal-text">DAPUR ANAK KOST</span>
        <h1>{{ $recipe->exists ? 'Edit resep' : 'Tambah resep baru' }}</h1>
        @if($errors->any())
            <div class="error-box"><strong>Periksa kembali isian berikut:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form method="POST" enctype="multipart/form-data" action="{{ $recipe->exists ? route('admin.recipes.update', $recipe) : route('admin.recipes.store') }}">
            @csrf
            @if($recipe->exists) @method('PUT') @endif
            <label>Nama resep<input name="title" value="{{ old('title', $recipe->title) }}" required></label>
            <label>Kategori<select name="category_id" required><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $recipe->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
            <label>Deskripsi<textarea name="description" rows="2" required>{{ old('description', $recipe->description) }}</textarea></label>
            <div class="form-row">
                <label>Waktu memasak (menit)<input type="number" name="cooking_time" min="1" value="{{ old('cooking_time', $recipe->cooking_time) }}" required></label>
                <label>Estimasi biaya (rupiah)<input type="number" name="estimated_cost" min="0" value="{{ old('estimated_cost', $recipe->estimated_cost) }}" required></label>
            </div>
            <label>Bahan-bahan <small>(satu bahan setiap baris)</small><textarea name="ingredients_text" rows="5" required>{{ old('ingredients_text', implode("\n", $recipe->ingredients ?? [])) }}</textarea></label>
            <label>Cara membuat <small>(satu langkah setiap baris)</small><textarea name="instructions_text" rows="5" required>{{ old('instructions_text', implode("\n", $recipe->instructions ?? [])) }}</textarea></label>
            <label>Foto resep (opsional)<input type="file" name="image" accept="image/*"></label>
            <button class="btn btn-primary" type="submit">{{ $recipe->exists ? 'Simpan perubahan' : 'Simpan resep' }}</button>
        </form>
    </div>
</section>
@endsection
