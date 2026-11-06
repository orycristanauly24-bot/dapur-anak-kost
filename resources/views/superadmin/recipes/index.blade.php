@extends('layouts.app')
@section('title', 'Kelola Semua Resep')
@section('content')
<div class="container" style="padding: 30px 0;">
    <h2>Kelola Semua Resep (Super Admin)</h2>
    <p class="text-muted">Kontrol penuh atas seluruh resep yang diposting di platform.</p>

    @if(session('success'))
        <div class="alert" style="background: #e6fffa; color: #007777; padding: 10px; border-radius: 6px; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; background: #f7fafc;">
                    <th style="padding: 12px;">Judul Resep</th>
                    <th style="padding: 12px;">Kategori</th>
                    <th style="padding: 12px;">Waktu & Biaya</th>
                    <th style="padding: 12px;">Ulasan</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recipes as $recipe)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; font-weight: 500;">
                            <a href="{{ route('recipes.show', $recipe->slug) }}" target="_blank" style="color: #007777; text-decoration: none;">{{ $recipe->title }}</a>
                        </td>
                        <td style="padding: 12px;">{{ $recipe->category->name ?? '-' }}</td>
                        <td style="padding: 12px; color: #4a5568; font-size: 0.9rem;">
                            ⏱ {{ $recipe->cooking_time }} mnt | 💰 Rp{{ number_format($recipe->estimated_cost, 0, ',', '.') }}
                        </td>
                        <td style="padding: 12px;">{{ $recipe->comments->count() }} Ulasan</td>
                        <td style="padding: 12px;">
                            <form action="{{ route('superadmin.recipes.destroy', $recipe->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #e53e3e; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.85rem;" onclick="return confirm('Yakin ingin menghapus resep ini secara permanen?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection@extends('layouts.app')
@section('title', 'Kelola Semua Resep')
@section('content')
<div class="container" style="padding: 30px 0;">
    <h2>Kelola Semua Resep (Super Admin)</h2>
    <p class="text-muted">Kontrol penuh atas seluruh resep yang diposting di platform.</p>

    @if(session('success'))
        <div class="alert" style="background: #e6fffa; color: #007777; padding: 10px; border-radius: 6px; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; background: #f7fafc;">
                    <th style="padding: 12px;">Judul Resep</th>
                    <th style="padding: 12px;">Kategori</th>
                    <th style="padding: 12px;">Waktu & Biaya</th>
                    <th style="padding: 12px;">Ulasan</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recipes as $recipe)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; font-weight: 500;">
                            <a href="{{ route('recipes.show', $recipe->slug) }}" target="_blank" style="color: #007777; text-decoration: none;">{{ $recipe->title }}</a>
                        </td>
                        <td style="padding: 12px;">{{ $recipe->category->name ?? '-' }}</td>
                        <td style="padding: 12px; color: #4a5568; font-size: 0.9rem;">
                            ⏱ {{ $recipe->cooking_time }} mnt | 💰 Rp{{ number_format($recipe->estimated_cost, 0, ',', '.') }}
                        </td>
                        <td style="padding: 12px;">{{ $recipe->comments->count() }} Ulasan</td>
                        <td style="padding: 12px;">
                            <form action="{{ route('superadmin.recipes.destroy', $recipe->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #e53e3e; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.85rem;" onclick="return confirm('Yakin ingin menghapus resep ini secara permanen?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection