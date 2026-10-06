<?php
session_start();
if (!isset($_SESSION["sesi"]) || $_SESSION["role"] != "penguasa") {
    header("Location: ../login.php?status=akses_terlarang");
    exit;
}

include '../process.php';
$conn = connect();

$query_film = mysqli_query($conn, "SELECT * FROM film");
$query_user = mysqli_query($conn, "SELECT * FROM pengguna");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cineboxd</title>
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

        /* Top Navigation Bar ala Sosmed */
        .navbar {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            color: var(--text-main);
            font-size: 1.2rem;
            margin: 0;
            letter-spacing: 1px;
        }

        .navbar h1 span {
            color: var(--accent-green);
        }

        .user-badge {
            background: #282725;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            color: var(--text-main);
            border: 1px solid var(--border-color);
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

        /* Container Layout */
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Card / Section Box */
        .card-section {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }

        .card-section h2 {
            color: var(--text-main);
            font-size: 1.1rem;
            margin-top: 0;
            margin-bottom: 20px;
            border-left: 4px solid var(--accent-green);
            padding-left: 10px;
            letter-spacing: 0.5px;
        }

        /* Form Styling */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input, textarea {
            width: 100%;
            padding: 10px 14px;
            background: #14181c;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 6px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 0.95rem;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--accent-green);
        }

        .btn-submit {
            background-color: var(--accent-yellow);
            color: #0c0c0c;
            border: none;
            padding: 12px 25px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background-color: #d4db22;
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-align: left;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        th {
            color: var(--text-main);
            background: #14181c;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <h1>CINEBOXD <span>// ADMIN PANEL</span></h1>
        <div style="display: flex; align-items: center; gap: 15px;">
            <span class="user-badge">👑 Penguasa: <?= htmlspecialchars($_SESSION["sesi"]); ?></span>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">

        <!-- Form Tambah Film / Nobar -->
        <div class="card-section">
            <h2>Tambah Film & Jadwal Nobar Baru</h2>
            <form action="../process.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Judul Film</label>
                        <input type="text" name="nama_film" placeholder="Contoh: Interstellar" required>
                    </div>
                    <div class="form-group">
                        <label>Sutradara / Author</label>
                        <input type="text" name="author" placeholder="Contoh: Christopher Nolan" required>
                    </div>
                    <div class="form-group full">
                        <label>Sinopsis / Jadwal Nobar (Step)</label>
                        <textarea name="step" rows="3" placeholder="Tulis sinopsis atau detail tempat & waktu nobar..." required></textarea>
                    </div>
                    <div class="form-group full">
                        <label>Ulasan Komunitas Awal</label>
                        <textarea name="ulasan" rows="2" placeholder="Ulasan awal atau catatan penonton..."></textarea>
                    </div>
                </div>
                <button type="submit" name="dor" value="TambahFilm" class="btn-submit">Simpan Film</button>
            </form>
        </div>

        <!-- Tabel Daftar Film -->
        <div class="card-section">
            <h2>Database Film & Jadwal Nobar Komunitas</h2>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Judul Film</th>
                        <th>Sinopsis / Jadwal</th>
                        <th>Author</th>
                        <th>Ulasan</th>
                    </tr>
                    <?php while($row = mysqli_fetch_assoc($query_film)) { ?>
                    <tr>
                        <td>#<?= $row['id_film']; ?></td>
                        <td style="color: #fff; font-weight: bold;"><?= htmlspecialchars($row['nama_film']); ?></td>
                        <td><?= htmlspecialchars($row['step']); ?></td>
                        <td><?= htmlspecialchars($row['author']); ?></td>
                        <td><?= htmlspecialchars($row['ulasan']); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <!-- Tabel Daftar Pengguna -->
        <div class="card-section">
            <h2>Database Anggota Komunitas (Pengguna)</h2>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role Akses</th>
                    </tr>
                    <?php while($usr = mysqli_fetch_assoc($query_user)) { ?>
                    <tr>
                        <td>#<?= $usr['id']; ?></td>
                        <td style="color: #fff; font-weight: bold;"><?= htmlspecialchars($usr['nama']); ?></td>
                        <td>@<?= htmlspecialchars($usr['username']); ?></td>
                        <td><?= htmlspecialchars($usr['email']); ?></td>
                        <td>
                            <span style="padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; background: <?= ($usr['role'] == 'penguasa') ? '#e6ed2e; color: #000;' : '#2c3440; color: #fff;'; ?>">
                                <?= strtoupper($usr['role']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

    </div>

</body>
</html>