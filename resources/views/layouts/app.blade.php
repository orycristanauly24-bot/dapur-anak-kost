<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dapur Anak Kost') | Dapur Anak Kost</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container nav-wrap">
            <a class="brand" href="{{ route('home') }}"><span class="brand-icon">🍳</span> Dapur<span>Anak Kost</span></a>
            <nav style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ route('home') }}">Beranda</a>

                @auth
                    {{-- Menu Kirim Resep --}}
                    <a href="{{ route('recipes.user.create') }}">Kirim Resep</a>

                    {{-- HANYA MUNCUL jika role-nya admin atau super_admin --TERYATAA BERLAKU JUGA DI SINI--}}
                    @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                        <a href="{{ route('admin.recipes.index') }}">Kelola Resep</a>
                    @endif

                    {{-- MENU KHUSUS SUPER ADMIN (Kelola Akun & Kategori) --}}
                    @if(auth()->user()->role === 'super_admin')
                        <a href="{{ route('superadmin.users.index') }}" style="color: #b7791f; font-weight: bold;">Kelola Akun</a>
                        <a href="{{ route('superadmin.categories.index') }}" style="color: #b7791f; font-weight: bold;">Kelola Kategori</a>
                    @endif

                    {{-- Kotak Nama User (Nama akun yang sedang login) --}}
                    <span style="background: #edf2f7; padding: 6px 12px; border-radius: 6px; font-size: 0.9rem; color: #2d3748; font-weight: 500;">
                        👤 {{ auth()->user()->name }}
                    </span>

                    {{-- Tombol Logout --}}
                    <form action="{{ route('logout') }}" method="POST" style="display: inline; margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #e53e3e; font: inherit; cursor: pointer; padding: 0; font-weight: bold;">Logout</button>
                    </form>
                @else
                    {{-- Tampil jika belum login (Tamu) --}}
                    <a href="{{ route('login') }}" style="background-color: #007777; color: white; padding: 6px 16px; border-radius: 20px; text-decoration: none;">Log in</a>
                    <a href="{{ route('register') }}" style="border: 1px solid #cbd5e0; color: #4a5568; padding: 6px 16px; border-radius: 20px; text-decoration: none;">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">© {{ date('Y') }} ORY DOKHSIA C || 224510090</div>
    </footer>
</body>
</html>