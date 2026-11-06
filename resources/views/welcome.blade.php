<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Dapur Anak Kost') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
            color: #1b1b18;
        }
        .bg-theme {
            background-color: #087e83 !important;
        }
        .text-theme {
            color: #087e83 !important;
        }
        .btn-theme {
            background-color: #087e83;
            color: #ffffff;
            border: none;
        }
        .btn-theme:hover {
            background-color: #066266;
            color: #ffffff;
        }
        .card-recipe {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-recipe:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header Navigation Section -->
    <header class="bg-white border-bottom sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="fs-4 fw-bold text-decoration-none text-theme d-flex align-items-center gap-2">
                <span>🍳</span> Dapur Anak Kost
            </a>

            <nav class="d-flex align-items-center gap-4">
                <a class="text-decoration-none text-secondary fw-semibold" href="{{ route('home') }}">Beranda</a>
                <a class="text-decoration-none text-secondary fw-semibold" href="{{ route('recipes.user.create') }}">Kirim Resep</a>

                @auth
                    <a class="text-decoration-none text-secondary fw-semibold" href="{{ route('admin.recipes.index') }}">Kelola Resep</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold rounded-pill px-3">Logout</button>
                    </form>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-theme btn-sm fw-semibold rounded-pill px-3">Log in</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">Register</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="container py-4 flex-grow-1">

        <!-- Banner Hero Section -->
        <div class="p-5 mb-5 rounded-4 text-white bg-theme shadow-sm">
            <div class="row align-items-center py-2">
                <div class="col-lg-8">
                    <span class="text-uppercase tracking-wider small fw-semibold opacity-75 d-block mb-2">
                        RESEP SIMPLE • BUDGET FRIENDLY
                    </span>
                    <h1 class="display-5 fw-bold mb-3">
                        Masak enak,<br>nggak bikin kantong bolong.
                    </h1>
                    <p class="fs-5 mb-4 opacity-90">
                        Kumpulan ide makanan praktis dan hemat untuk menemani hari-hari anak kost.
                    </p>
                    <a href="#daftar-resep" class="btn btn-light fw-bold px-4 py-2 rounded-pill text-theme shadow-sm">
                        Cari inspirasi masak ↓
                    </a>
                </div>
            </div>
        </div>

        <!-- Daftar Resep Section -->
        <section id="daftar-resep" class="py-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Resep Terbaru</h3>
                <span class="text-muted small">Ide masak hemat harian</span>
            </div>

            <div class="row g-4">
                @forelse ($recipes ?? [] as $recipe)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-recipe bg-white">
                            @if (isset($recipe->image) && $recipe->image)
                                <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top" alt="{{ $recipe->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                                    <span class="small">Tidak Ada Foto</span>
                                </div>
                            @endif

                            <div class="card-body p-4">
                                <span class="badge bg-info-subtle text-info-emphasis mb-2 rounded-pill px-2.5 py-1">
                                    {{ $recipe->category->name ?? 'Umum' }}
                                </span>
                                <h5 class="card-title fw-bold text-dark mb-2">{{ $recipe->title }}</h5>
                                <p class="card-text text-secondary small">
                                    {{ Str::limit($recipe->description ?? 'Deskripsi resep belum tersedia.', 100) }}
                                </p>
                            </div>

                            <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-primary w-100 btn-sm fw-bold rounded-pill">
                                    Lihat Resep
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="p-5 bg-white rounded-4 shadow-sm">
                            <span class="fs-1 d-block mb-3">🍳</span>
                            <h5 class="fw-bold text-dark">Belum Ada Resep</h5>
                            <p class="text-secondary small mb-0">Resep masakan anak kost akan tampil di sini setelah ditambahkan.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <!-- Footer Section -->
    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center text-secondary small">
            <p class="mb-0">&copy; {{ date('Y') }} ORY DOKHSIA C || 224510090</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.bundle.min.js"></script>
</body>
</html>