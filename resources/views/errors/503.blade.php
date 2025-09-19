<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff6a00, #ee0979, #00c6ff);
            background-size: 300% 300%;
            animation: gradientBG 10s ease infinite;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            text-align: center;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            padding: 40px 30px;
            max-width: 500px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.9;
            }
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .loader {
            margin: 20px auto;
            border: 8px solid rgba(255, 255, 255, 0.3);
            border-top: 8px solid #fff;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            animation: spin 1.2s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .btn-custom {
            background: #fff;
            color: #ee0979;
            font-weight: bold;
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom:hover {
            background: #ff6a00;
            color: #fff;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="card text-white text-center">
        <!-- Logo -->

      <div class="text-center my-3">
    <img
        src="{{ asset('backend/img/MBC.svg') }}"
        alt="MBC Logo"
        style="height: 100px; width: 150px; background:#fff; padding:10px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.2);" />
</div>


        <h1>Website Sedang Maintenance </h1>
        <p class="mt-3"> <b>
Kami sedang melakukan perbaikan & peningkatan sistem.<br>
 
         Silakan tunggu beberapa saat lagi
        </b> 🙏</p>

        <div class="loader"></div>

        <a href="/" class="btn btn-custom mt-3">🔄 Coba Lagi</a>

        <p class="mt-4 mb-0"><small>&copy; 2025 MBC Hamasah</small></p>
    </div>
</body>

</html>