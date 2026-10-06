<?php
session_start();
// Cek apakah user sudah login dan memiliki role rakyat (User biasa)
if (!isset($_SESSION["sesi"]) || $_SESSION["role"] != "rakyat") {
    header("Location: ../login.php?status=akses_terlarang");
    exit;
}

include '../process.php';
$conn = connect();

// Ambil data film & ulasan komunitas dari database
$query_feed = mysqli_query($conn, "SELECT * FROM film ORDER BY id_film DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed Komunitas - Cineboxd</title>
    <link rel="stylesheet" href="../loop_data/style.css">
    <style>
        :root {
            --bg-main: #0c0c0c;
            --bg-card: #1c2229;
            --border-color: #2c3440;
            --text-main: #ffffff;
            --text-muted: #9ab;
            --accent-yellow: #e6ed2e;
            --accent-green: #00e054;
            --danger: #ff4d4d;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-muted);
            font-family: 'Montserrat', sans-serif, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar Sosmed */
        .navbar {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar h1 {
            color: var(--text-main);
            font-size: 1.2rem;
            margin: 0;
            letter-spacing: 1px;
        }

        .navbar h1 span {
            color: var(--accent-yellow);
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
            transition: 0.2s;
        }

        .nav-links a:hover {
            color: var(--accent-yellow);
        }

        .logout-btn {
            background: transparent;
            color: var(--danger);
            border: 1px solid var(--danger);
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: #fff;
        }

        /* Container Utama */
        .container {
            max-width: 700px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .welcome-banner {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-banner h3 {
            color: var(--text-main);
            margin: 0 0 5px 0;
        }

        /* Post Card (Feed Sosmed) */
        .post-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }

        .post-author {
            color: var(--text-main);
            font-weight: bold;
            font-size: 0.95rem;
        }

        .movie-title {
            color: var(--accent-yellow);
            font-size: 1.3rem;
            font-weight: bold;
            margin: 0 0 10px 0;
        }

        .post-content {
            font-size: 0.95rem;
            color: #c7d1db;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .review-box {
            background: #14181c;
            border-left: 3px solid var(--accent-green);
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .review-box span {
            color: var(--accent-green);
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <h1>CINEBOXD <span>// COMMUNITY FEED</span></h1>
        <div class="nav-links">
            <a href="index.php">Feed</a>
            <span style="color: var(--text-main);">Halo, @<?= htmlspecialchars($_SESSION["sesi"]); ?>!</span>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">

        <!-- Banner Profil Ringkas -->
        <div class="welcome-banner">
            <div>
                <h3>Selamat Datang di Cineboxd!</h3>
                <p style="margin: 0; font-size: 0.85rem;">Jelajahi ulasan film, temukan jadwal nobar, dan berinteraksi dengan komunitas.</p>
            </div>
            <div style="background: #282725; padding: 8px 15px; border-radius: 20px; border: 1px solid var(--border-color); font-size: 0.85rem; color: var(--accent-yellow);">
                🎬 Member Komunitas
            </div>
        </div>

        <!-- Loop Feed Film & Ulasan -->
        <h3 style="color: var(--text-main); margin-bottom: 15px; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;">Aktivitas & Ulasan Terbaru</h3>

        <?php while($row = mysqli_fetch_assoc($query_feed)) { ?>
        <div class="post-card">
            <div class="post-header">
                <span class="post-author">👤 Pengunggah: <?= htmlspecialchars($row['author']); ?></span>
                <span style="font-size: 0.75rem; color: var(--text-muted);">ID Film #<?= $row['id_film']; ?></span>
            </div>

            <h2 class="movie-title"><?= htmlspecialchars($row['nama_film']); ?></h2>
            
            <div class="post-content">
                <strong>Sinopsis / Jadwal Nobar:</strong><br>
                <?= nl2br(htmlspecialchars($row['step'])); ?>
            </div>

            <?php if(!empty($row['ulasan'])) { ?>
            <div class="review-box">
                <span>Ulasan Komunitas</span>
                <?= htmlspecialchars($row['ulasan']); ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

    </div>

</body>
</html>