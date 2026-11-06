
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Dapur Anak Kost</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #dff7f3, #b8e5df);
            padding: 20px;
        }

        .register-box {
            width: 100%;
            max-width: 430px;
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #087e83;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #789;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin: 15px 0 7px;
            color: #345;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbdedb;
            border-radius: 9px;
            outline: none;
        }

        input:focus {
            border-color: #0d9999;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            border: none;
            border-radius: 9px;
            background: #078b91;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #066d73;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #789;
        }

        a {
            color: #078b91;
            text-decoration: none;
            font-weight: bold;
        }

        .error {
            color: #d33;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="register-box">

    <h2>🍳 Dapur Anak Kost</h2>
    <p class="subtitle">Buat akun dan bagikan ide masakanmu!</p>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <label>Nama Lengkap</label>
        <input type="text" name="name"
               value="{{ old('name') }}"
               placeholder="Masukkan nama lengkap" required>

        <label>Email</label>
        <input type="email" name="email"
               value="{{ old('email') }}"
               placeholder="Masukkan email" required>

        <label>Password</label>
        <input type="password" name="password"
               placeholder="Minimal 8 karakter" required>

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation"
               placeholder="Ulangi password" required>

        <button type="submit">Daftar Sekarang</button>
    </form>

    <div class="footer">
        Sudah punya akun?
        <a href="{{ route('login') }}">Login di sini</a>
    </div>

</div>

</body>
</html>
