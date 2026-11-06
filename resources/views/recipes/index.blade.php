
@extends('layouts.app')

@section('title', 'Resep Hemat')

@section('content')

<section class="hero">
    <div class="container hero-inner">
        <div>
            <span class="eyebrow">RESEP SIMPLE • BUDGET FRIENDLY</span>
            <h1>Masak enak,<br><span>nggak bikin kantong bolong.</span></h1>
            <p>Kumpulan ide makanan praktis dan hemat untuk menemani hari-hari anak kost.</p>
            <a class="btn btn-light" href="#daftar-resep">Cari inspirasi masak ↓</a>
        </div>

        <div class="hero-art">🥘</div>
    </div>
</section>

<section class="container content-section" id="daftar-resep">

    <div class="section-heading">
        <div>
            <span class="eyebrow teal-text">PILIHAN ANAK KOST</span>
            <h2>Resep pilihan</h2>
        </div>

        <span class="muted">{{ $recipes->count() }} resep ditemukan</span>
    </div>

    {{-- Tombol kirim resep untuk pengguna yang sudah login --}}
    @auth
        <div class="mb-4">
            <a class="btn btn-primary" href="{{ route('recipes.user.create') }}">
                + Kirim Resep
            </a>
        </div>
    @endauth

    <form class="search-bar" method="GET" action="{{ route('home') }}">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari nama resep..."
        >

        <select name="category">
            <option value="">Semua kategori</option>

            @foreach($categories as $category)
                <option
                    value="{{ $category->slug }}"
                    @selected(request('category') === $category->slug)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-primary" type="submit">Cari</button>
    </form>

    <div class="recipe-grid">
        @forelse($recipes as $recipe)
            <article class="recipe-card">

                @if($recipe->image)
                    <img
                        class="recipe-image"
                        src="{{ asset('storage/'.$recipe->image) }}"
                        alt="{{ $recipe->title }}"
                    >
                @else
                    <div class="recipe-placeholder">🍜</div>
                @endif

                <div class="recipe-body">
                    <span class="category-tag">
                        {{ $recipe->category->name }}
                    </span>

                    <h3>{{ $recipe->title }}</h3>

                    <p>{{ $recipe->description }}</p>

                    <div class="recipe-meta">
                        <span>⏱ {{ $recipe->cooking_time }} menit</span>
                        <span>Rp{{ number_format($recipe->estimated_cost, 0, ',', '.') }}</span>
                    </div>

                    <a class="text-link" href="{{ route('recipes.show', $recipe) }}">
                        Lihat resep →
                    </a>
                </div>
            </article>
        @empty
            <div class="empty-state">
                Belum ada resep yang cocok. Coba kata kunci lain, ya!
            </div>
        @endforelse
    </div>

</section>

@endsection
