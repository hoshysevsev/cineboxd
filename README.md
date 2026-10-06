 Project Cineboxd

Ini adalah project aplikasi web Cineboxd. Web ini dilengkapi dengan fitur login, register, dan pembagian hak akses (multi-role) untuk Admin dan User.
Fitur yang ada:
- Landing Page: Halaman awal sebelum user login.
- Login & Register: Buat daftar akun baru dan masuk ke sistem.
- Dashboard Multi-role: 
  - Halaman khusus buat Admin.
  - Halaman khusus buat User biasa.
- Fitur Tambahan: Ada fungsi search dan halaman drag & drop.

 Cara Menjalankan Project:
Kalau mau coba jalanin web ini di laptop/komputer sendiri, ikutin langkah ini:

1. Pindahin folder
   Copy atau pindahin folder `Cineboxd` ini ke dalam folder `htdocs` (kalau kamu pakai XAMPP).
2. Nyalain XAMPP
   Buka XAMPP, lalu start/nyalakan bagian Apache dan MySQL.
3. Setup Database 
   - Buka browser, masuk ke `localhost/phpmyadmin`.
   - Bikin database baru (sesuaikan namanya dengan yang ada di kodingan).
   - Note: File database (.sql) bakal menyusul di-upload di tahap selanjutnya.
4. Buka Web
   Buka tab baru di browser, terus ketik alamat ini: `localhost/Cineboxd`

 Penjelasan Isi Folder:
- `admin/` = Isinya halaman dan fitur yang cuma bisa dibuka sama admin.
- `user/` = Isinya halaman khusus buat user.
- `loop_data/` = Folder buat nyimpen file pendukung kayak CSS dan fitur lainnya.
- File PHP di luar (kayak `index.php`, `login.php`, dll) = Itu file buat halaman utama, sistem login, dan register.
