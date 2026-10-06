<?php
session_start();

// Fungsi Koneksi Database MySQL
function connect(){
    $conn = mysqli_connect("localhost", "root", "", "cineboxd");
    if ($conn->connect_errno){
        die("Koneksi database gagal: " . $conn->connect_error);
    }
    return $conn;
}

// Fungsi pengecekan data POST
function cek_data_post($jenis){
    return isset($_POST[$jenis]) ? $_POST[$jenis] : null;
}

// Fungsi pengecekan data GET
function cek_data_get($jenis){
    return isset($_GET[$jenis]) ? $_GET[$jenis] : null;
}

// Fungsi Pendaftaran Akun Baru (Role otomatis 'rakyat' untuk member komunitas)
function register($nama, $email, $username, $password){
    $conn = connect();
    $query = "INSERT INTO pengguna VALUES (NULL, '$nama', '$email', '$username', '$password', 'rakyat')";
    if(mysqli_query($conn, $query)){
        header("Location: login.php?status=success");
    } else {
        header("Location: sign_up.php?status=gagal");
    }
}

// Fungsi Login dengan Pengecekan Role ('penguasa' = Admin, 'rakyat' = User)
function login($user, $pass){
    $conn = connect();
    $query = "SELECT * FROM pengguna WHERE username = '$user' AND password = '$pass'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $_SESSION["sesi"] = $row["username"];
        $_SESSION["role"] = $row["role"];

        // Redirect berdasarkan role database
        if($row["role"] == "penguasa"){
            header("Location: admin/index.php");
        } else {
            header("Location: user/index.php");
        }
    } else {
        header("Location: login.php?status=salah");
    }
}

// Fungsi Tambah Film & Jadwal Nobar (Struktur tabel film: nama_film, step, author, ulasan)
function add_film($nama_film, $step, $author, $ulasan){
    $conn = connect();
    $query = "INSERT INTO film VALUES (NULL, '$nama_film', '$step', '$author', '$ulasan')";
    mysqli_query($conn, $query);
    header("Location: admin/index.php?status=sukses_tambah");
}

// Eksekusi Logika Berdasarkan Tombol Form (Atribut name="dor")
if (cek_data_post("dor") == "Log In"){
    login(
        cek_data_post("username"),
        cek_data_post("password")
    );
}
elseif (cek_data_post("dor") == "Daftar"){
    register(
        cek_data_post("nama"),
        cek_data_post("email"),
        cek_data_post("username"),
        cek_data_post("password")
    );
} 
elseif (cek_data_post("dor") == "TambahFilm"){ 
    add_film(
        cek_data_post("nama_film"),
        cek_data_post("step"),
        cek_data_post("author"),
        cek_data_post("ulasan")
    );
}
?>