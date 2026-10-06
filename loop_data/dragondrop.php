<?php
session_start();
if (!isset($_SESSION["sesi"])) {
    header("Location: ../login.php?status=akses_terlarang");
    exit;
}

include '../process.php';
$conn = connect();
$query_film = mysqli_query($conn, "SELECT * FROM film");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Watchlist - Cineboxd</title>
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
            max-width: 600px;
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
            border-left: 4px solid var(--accent-yellow);
            padding-left: 10px;
            margin-bottom: 20px;
        }

        p {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        /* Sortable List Styling */
        #sortable-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sortable-item {
            background: #14181c;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 14px 18px;
            margin-bottom: 10px;
            border-radius: 6px;
            cursor: grab;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            transition: background 0.2s, border-color 0.2s;
        }

        .sortable-item:active {
            cursor: grabbing;
        }

        .sortable-item:hover {
            border-color: var(--accent-yellow);
            background: #1f2833;
        }

        .badge-id {
            background: #2c3440;
            color: var(--accent-yellow);
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .btn-back:hover {
            color: var(--text-main);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Atur Urutan Watchlist Film</h2>
        <p>Tarik dan geser (Drag & Drop) daftar film di bawah ini untuk mengatur urutan prioritas tontonan favorit Anda.</p>

        <ul id="sortable-list">
            <?php while($row = mysqli_fetch_assoc($query_film)) { ?>
            <li class="sortable-item" draggable="true">
                <span>🎬 <?= htmlspecialchars($row['nama_film']); ?></span>
                <span class="badge-id">ID #<?= $row['id_film']; ?></span>
            </li>
            <?php } ?>
        </ul>

        <a href="../user/index.php" class="btn-back">&larr; Kembali ke Feed Komunitas</a>
    </div>

    <!-- Script Sederhana untuk Efek Drag & Drop -->
    <script>
        const list = document.getElementById('sortable-list');
        let draggingItem = null;

        list.addEventListener('dragstart', (e) => {
            draggingItem = e.target;
            setTimeout(() => e.target.style.opacity = '0.5', 0);
        });

        list.addEventListener('dragend', (e) => {
            e.target.style.opacity = '1';
            draggingItem = null;
        });

        list.addEventListener('dragover', (e) => {
            e.preventDefault();
            const afterElement = getDragAfterElement(list, e.clientY);
            const currentItem = document.querySelector('.dragging');
            if (afterElement == null) {
                list.appendChild(draggingItem);
            } else {
                list.insertBefore(draggingItem, afterElement);
            }
        });

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.sortable-item:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }
    </script>

</body>
</html>