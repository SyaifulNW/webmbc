<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Manajemen Customer Service MBC HAMASAH</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #370331, #e10338);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }

        .logo img {
            width: 120px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        p {
            max-width: 600px;
            font-size: 1rem;
            line-height: 1.5;
        }

        .button {
            margin-top: 20px;
        }

        .button a {
            background: #facc15;
            color: black;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .button a:hover {
            background: #eab308;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="{{ asset('backend/Helas.jpg') }}" alt="Logo MBC HAMASAH">
    </div>
    <h1>HELAS COORPORATION</h1>
    <h2>Sistem Informasi Manajemen </h2>
    <p>Selamat datang di sistem manajemen perusahaan kami.
        Akses data peserta, rencana penjualan, dan aktivitas harian dengan mudah.</p>
    <div class="button">
        <a href="{{ route('home') }}">Masuk </a>
    </div>
</body>

</html>