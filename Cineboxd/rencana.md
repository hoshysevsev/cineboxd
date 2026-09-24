Nama Projek
Cineboxd

Deskripsi
Mencari, menyimpan, dan mengurutkan daftar tontonan film favorit serta memberikan ulasan.

Unique Value
Mutualan, nobar, bangun komunitas, mini sosmed.

Penyesuaian Struktur File (Folder Project)
Mengikuti pola struktur folder resepku pada gambar:

Cineboxd/
├── admin/
│   └── index.php           (Dashboard admin untuk kelola data film/user)
├── loop_data/
│   ├── dragdrop.php        (Fitur reorder/mengurutkan watchlist)
│   ├── search.php          (Pencarian film & cari teman/mutualan)
│   └── style.css           (Styling tampilan ala sosmed/dark mode)
├── user/
│   └── index.php           (Feed sosmed: watchlist, ulasan teman, & fitur nobar)
├── login.php               (Halaman masuk)
├── logout.php              (Proses keluar)
├── process.php             (Proses CRUD, follow/mutualan, & post ulasan)
└── sign_up.php             (Pendaftaran akun baru)

Penyesuaian Skema Database (MySQL)
Mengikuti struktur tabel pada gambar (pengguna, bahan, dan resep):

1. Tabel pengguna (Sama persis dengan gambar)
id : int(11), Auto Increment, Primary Key
nama : varchar(256)
email : text
username : text
password : varchar(255)
role : enum(penguasa, rakyat) — penguasa = Admin, rakyat = User/Member komunitas

2. Tabel genre (Menggantikan tabel bahan)
id_genre : int(11), Auto Increment, Primary Key
nama : varchar(255) (contoh: Action, Drama, Nobar Spot)

3. Tabel film (Menggantikan tabel resep)
id_film : int(11), Auto Increment, Primary Key
nama_film : text (Judul film)
step : text (Deskripsi/Sinopsis & Info Jadwal Nobar)
author : varchar(255)` (Sutradara / Pengunggah postingan)
ulasan : text (Ulasan film / Komentar antar sesama anggota komunitas)