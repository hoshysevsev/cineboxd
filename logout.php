<?php
session_start();
// Hapus semua data sesi yang aktif
session_unset();
session_destroy();

// Arahkan kembali ke halaman utama / login
header("Location: login.php?status=logout");
exit;
?>