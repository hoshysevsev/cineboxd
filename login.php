<?php
session_start();
// Jika sudah login, lempar langsung ke dashboard
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
    <title>Masuk - Cineboxd</title>
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
            --danger: #ff4d4d;
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

        .auth-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 35px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            box-sizing: border-box;
        }

        .auth-card h2 {
            color: var(--text-main);
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        .auth-card h2 span {
            color: var(--accent-yellow);
        }

        .alert-error {
            background: rgba(255, 77, 77, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input {
            width: 100%;
            padding: 10px 14px;
            background: #14181c;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 6px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 0.95px;
        }

        input:focus {
            outline: none;
            border-color: var(--accent-yellow);
        }

        .btn-submit {
            width: 100%;
            background-color: var(--accent-yellow);
            color: #0c0c0c;
            border: none;
            padding: 12px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background-color: #d4db22;
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
        }

        .auth-footer a {
            color: var(--accent-yellow);
            text-decoration: none;
            font-weight: bold;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <h2>CINEBOXD <span>// LOGIN</span></h2>

        <?php if(isset($_GET['status']) && $_GET['status'] == 'salah'): ?>
            <div class="alert-error">Username atau Password salah!</div>
        <?php endif; ?>

        <form action="process.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username..." required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password..." required>
            </div>

            <button type="submit" name="dor" value="Log In" class="btn-submit">Masuk</button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="sign_up.php">Daftar di sini</a>
        </div>
    </div>

</body>
</html>