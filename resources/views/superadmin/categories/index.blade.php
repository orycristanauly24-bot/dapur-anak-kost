@extends('layouts.app')
@section('title', 'Kelola Kategori')
@section('content')
<div class="container" style="padding: 30px 0;">
    <h2>Kelola Kategori Resep</h2>
    <p class="text-muted">Tambah atau hapus kategori masakan.</p>

    @if(session('success'))
        <div class="alert" style="background: #e6fffa; color: #007777; padding: 10px; border-radius: 6px; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('superadmin.categories.store') }}" method="POST" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; display: flex; gap: 10px;">
        @csrf
        <input type="text" name="name" placeholder="Nama Kategori Baru..." style="flex: 1; padding: 8px; border: 1px solid #cbd5e0; border-radius: 6px;" required>
        <button type="submit" style="background: #007777; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">Tambah</button>
    </form>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; background: #f7fafc;">
                    <th style="padding: 12px;">Nama Kategori</th>
                    <th style="padding: 12px;">Slug</th>
                    <th style="padding: 12px;">Jumlah Resep</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; font-weight: 500;">{{ $cat->name }}</td>
                        <td style="padding: 12px; color: #4a5568;">{{ $cat->slug }}</td>
                        <td style="padding: 12px;">{{ $cat->recipes_count }} Resep</td>
                        <td style="padding: 12px;">
                            <form action="{{ route('superadmin.categories.destroy', $cat->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #e53e3e; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.85rem;" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection