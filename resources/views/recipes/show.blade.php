@extends('layouts.app')
@section('title', $recipe->title)
@section('content')
<section class="container detail-wrap">
    <a class="back-link" href="{{ route('home') }}">← Kembali ke resep</a>
    <div class="detail-card">
        @if($recipe->image)
            <img class="detail-image" src="{{ asset('storage/'.$recipe->image) }}" alt="{{ $recipe->title }}">
        @else
            <div class="detail-placeholder">🍲</div>
        @endif
        <div class="detail-content">
            <span class="category-tag">{{ $recipe->category->name }}</span>
            <h1>{{ $recipe->title }}</h1>
            <p class="lead">{{ $recipe->description }}</p>
            <div class="detail-meta">
                <span>⏱ {{ $recipe->cooking_time }} menit</span>
                <span>💰 Estimasi Rp{{ number_format($recipe->estimated_cost, 0, ',', '.') }}</span>
                <span>⭐ Rata-rata Rating: {{ number_format($recipe->averageRating(), 1) }} / 5</span>
            </div>
            <div class="two-columns">
                <section><h2>Bahan-bahan</h2><ul class="step-list">@foreach($recipe->ingredients as $ingredient)<li>{{ $ingredient }}</li>@endforeach</ul></section>
                <section><h2>Cara membuat</h2><ol class="step-list">@foreach($recipe->instructions as $instruction)<li>{{ $instruction }}</li>@endforeach</ol></section>
            </div>

            <hr class="my-5">

            <!-- BAGIAN KOMENTAR & RATING -->
            <div class="comments-section mt-4">
                <h3>Ulasan & Rating Resep</h3>

                @if(session('success'))
                    <div class="alert alert-success" style="padding: 10px; background: #e6fffa; color: #007777; border-radius: 6px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form Kirim Komentar (Hanya muncul jika sudah login) --}}
                @auth
                    <form action="{{ route('comments.store', $recipe->id) }}" method="POST" class="mb-4" style="background: #f7fafc; padding: 20px; border-radius: 8px;">
                        @csrf
                        <div class="mb-3" style="margin-bottom: 12px;">
                            <label for="rating" style="display: block; font-weight: 500; margin-bottom: 5px;">Rating Bintang:</label>
                            <select name="rating" id="rating" class="form-control" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e0;" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Enak)</option>
                                <option value="4">⭐⭐⭐⭐ (4 - Enak)</option>
                                <option value="3">⭐⭐⭐ (3 - Lumayan)</option>
                                <option value="2">⭐⭐ (2 - Kurang)</option>
                                <option value="1">⭐ (1 - Tidak Suka)</option>
                            </select>
                        </div>
                        <div class="mb-3" style="margin-bottom: 12px;">
                            <label for="comment" style="display: block; font-weight: 500; margin-bottom: 5px;">Ulasan Kamu:</label>
                            <textarea name="comment" id="comment" rows="3" class="form-control" placeholder="Tulis tanggapan atau pengalamanmu memasak resep ini..." style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e0;" required></textarea>
                        </div>
                        <button type="submit" class="btn" style="background-color: #007777; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: 500;">Kirim Ulasan</button>
                    </form>
                @else
                    <p style="background: #fffaf0; padding: 12px; border-radius: 6px; border: 1px solid #feebc8;">
                        <a href="{{ route('login') }}" style="color: #007777; font-weight: bold;">Login</a> untuk ikut memberikan komentar dan rating pada resep ini.
                    </p>
                @endauth

                <!-- Daftar Komentar -->
                <div class="list-comments mt-4">
                    @forelse($recipe->comments as $item)
                        <div class="comment-card mb-3 p-3" style="background: #f8f9fa; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 12px; padding: 15px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <strong>👤 {{ $item->user->name }}</strong>
                                <span style="font-size: 0.85rem; color: #718096;">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <div style="color: #d69e2e; margin: 4px 0;">
                                {!! str_repeat('⭐', $item->rating) !!} <span style="color: #4a5568; font-size: 0.9rem;">({{ $item->rating }}/5)</span>
                            </div>
                            <p style="margin: 8px 0 0 0; color: #2d3748;">{{ $item->comment }}</p>

                            {{-- Tombol Hapus: Muncul jika yang login adalah pemilik komentar ATAU super_admin --}}
                            @auth
                                @if(auth()->id() === $item->user_id || auth()->user()->role === 'super_admin')
                                    <form action="{{ route('comments.destroy', $item->id) }}" method="POST" style="margin-top: 8px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #e53e3e; padding: 0; font-size: 0.85rem; cursor: pointer; font-weight: 500;" onclick="return confirm('Yakin ingin menghapus komentar ini?')">Hapus Komentar</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @empty
                        <p class="text-muted" style="color: #718096; font-style: italic;">Belum ada ulasan untuk resep ini. Jadilah yang pertama memberikan ulasan!</p>
                    @endforelse
                </div>
            </div>
            <!-- AKHIR BAGIAN KOMENTAR -->

        </div>
    </div>
</section>
@endsection