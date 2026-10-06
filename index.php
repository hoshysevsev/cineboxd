<?php
session_start();
// Jika sudah login, arahkan otomatis ke dashboard masing-masing role agar tidak perlu login ulang
if (isset($_SESSION["sesi"])) {
    if ($_SESSION["role"] == "penguasa") {
        header("Location: admin/index.php");
        exit;
    } else {
        header("Location: user/index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cineboxd - Jejaring Sosial & Watchlist Film Komunitas</title>
    <link rel="stylesheet" href="loop_data/style.css">
    <style>
        :root {
            --bg-main: #0c0c0c;
            --bg-card: #1c2229;
            --border-color: #2c3440;
            --text-main: #ffffff;
            --text-muted: #9ab;
            --accent-yellow: #e6ed2e;
            --accent-green: #00e054;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-muted);
            font-family: 'Montserrat', sans-serif, Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .hero-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
        }

        .hero-container h1 {
            color: var(--text-main);
            font-size: 2.2rem;
            margin-bottom: 10px;
            letter-spacing: 1.5px;
        }

        .hero-container h1 span {
            color: var(--accent-green);
        }

        .hero-container p {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.2s;
        }

        .btn-login {
            background-color: var(--accent-yellow);
            color: #0c0c0c;
        }

        .btn-login:hover {
            background-color: #d4db22;
        }

        .btn-register {
            background-color: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .btn-register:hover {
            background-color: rgba(255,255,255,0.05);
            border-color: var(--text-muted);
        }

        .features-hint {
            margin-top: 30px;
            font-size: 0.8rem;
            color: #6c757d;
            border-top: 1px solid var(--border-color);
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="hero-container">
        <h1>CINEBOXD <span>// SOCIAL</span></h1>
        <p>Lacak film favoritmu, buat watchlist, tulis ulasan, dan temukan jadwal nobar bareng komunitas pencinta film.</p>
        
        <div class="btn-group">
            <a href="login.php" class="btn btn-login">Masuk</a>
            <a href="sign_up.php" class="btn btn-register">Daftar</a>
        </div>

        <div class="features-hint">
            ✨ Fitur Unggulan: Mutualan, Nobar Spot, & Ulasan Komunitas
        </div>
    </div>

</body>
</html>