@extends('layouts.app') {{-- Menghubungkan ke layout app.blade.php --}}

@section('title', 'Kirim Resep')

@section('content')
<div class="container" style="padding: 20px 0;">
    <h2>Kirim Resep Baru</h2>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Route disesuaikan menjadi recipes.user.store --}}
    <form action="{{ route('recipes.user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Judul Resep</label><br>
            <input type="text" name="title" value="{{ old('title') }}" style="width: 100%; padding: 8px;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Kategori</label><br>
            <select name="category_id" style="width: 100%; padding: 8px;" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Deskripsi Singkat</label><br>
            <textarea name="description" rows="3" style="width: 100%; padding: 8px;" required>{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Bahan-Bahan (Tulis 1 bahan per baris)</label><br>
            <textarea name="ingredients_text" rows="5" style="width: 100%; padding: 8px;" required>{{ old('ingredients_text') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Langkah Pembuatan (Tulis 1 langkah per baris)</label><br>
            <textarea name="instructions_text" rows="5" style="width: 100%; padding: 8px;" required>{{ old('instructions_text') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Waktu Memasak (Menit)</label><br>
            <input type="number" name="cooking_time" value="{{ old('cooking_time') }}" style="width: 100%; padding: 8px;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Estimasi Biaya (Rp)</label><br>
            <input type="number" name="estimated_cost" value="{{ old('estimated_cost') }}" style="width: 100%; padding: 8px;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Foto Resep</label><br>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Kirim Resep</button>
    </form>
</div>
@endsection