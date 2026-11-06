@extends('layouts.app')
@section('title', 'Kelola Resep')
@section('content')
<section class="container content-section admin-section">
    <div class="section-heading">
        <div><span class="eyebrow teal-text">PENGELOLAAN</span><h1>Kelola resep</h1><p class="muted">Tambah, ubah, atau hapus resep Dapur Anak Kost.</p></div>
        <a class="btn btn-primary" href="{{ route('admin.recipes.create') }}">+ Tambah resep</a>
    </div>
    @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
    <div class="table-wrap"><table>
        <thead><tr><th>Nama resep</th><th>Kategori</th><th>Biaya</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($recipes as $recipe)
            <tr>
                <td><strong>{{ $recipe->title }}</strong></td>
                <td>{{ $recipe->category->name }}</td>
                <td>Rp{{ number_format($recipe->estimated_cost, 0, ',', '.') }}</td>
                <td class="actions"><a class="text-link" href="{{ route('admin.recipes.edit', $recipe) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.recipes.destroy', $recipe) }}" onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
                        @csrf @method('DELETE')<button class="delete-link" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada data resep.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</section>
@endsection
