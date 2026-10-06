<?php
session_start();
if (!isset($_SESSION["sesi"])) {
    header("Location: ../login.php?status=akses_terlarang");
    exit;
}

include '../process.php';
$conn = connect();

// Logika pencarian sederhana
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
$query_result = null;

if (!empty($keyword)) {
    $query_result = mysqli_query($conn, "SELECT * FROM film WHERE nama_film LIKE '%$keyword%' OR author LIKE '%$keyword%'");
} else {
    $query_result = mysqli_query($conn, "SELECT * FROM film LIMIT 5");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian - Cineboxd</title>
    <link rel="stylesheet" href="style.css">
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
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 30px auto;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
        }

        h2 {
            color: var(--text-main);
            margin-top: 0;
            font-size: 1.3rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-left: 4px solid var(--accent-green);
            padding-left: 10px;
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        input[type="text"] {
            flex: 1;
            padding: 12px 15px;
            background: #14181c;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 6px;
            font-size: 0.95rem;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--accent-green);
        }

        button {
            background-color: var(--accent-green);
            color: #0c0c0c;
            border: none;
            padding: 0 20px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        button:hover {
            background-color: #00c046;
        }

        .result-card {
            background: #14181c;
            border: 1px solid var(--border-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .result-card h4 {
            color: var(--accent-yellow);
            margin: 0 0 5px 0;
            font-size: 1.1rem;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-back:hover {
            color: var(--text-main);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Cari Film & Komunitas</h2>
        
        <form method="GET" class="search-form">
            <input type="text" name="keyword" placeholder="Cari judul film atau sutradara/pengunggah..." value="<?= htmlspecialchars($keyword); ?>">
            <button type="submit">Cari</button>
        </form>

        <h3 style="color: var(--text-main); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Hasil Pencarian:</h3>

        <?php if($query_result && mysqli_num_rows($query_result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($query_result)): ?>
                <div class="result-card">
                    <h4>🎬 <?= htmlspecialchars($row['nama_film']); ?></h4>
                    <p style="margin: 0 0 8px 0; font-size: 0.85rem;"><strong>Pengunggah / Author:</strong> <?= htmlspecialchars($row['author']); ?></p>
                    <p style="margin: 0; font-size: 0.9rem; color: #c7d1db;"><?= htmlspecialchars($row['step']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color: #ff4d4d;">Film atau data yang dicari tidak ditemukan.</p>
        <?php endif; ?>

        <a href="../user/index.php" class="btn-back">&larr; Kembali ke Feed Komunitas</a>
    </div>

</body>
</html>