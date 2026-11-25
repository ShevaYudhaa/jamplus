# JAMPLUS — Monitoring Jam Plus & Soft Skill Mahasiswa

Website berbasis **Laravel 12 + Blade + Tailwind CSS + MySQL/MariaDB**. UI dan aturan akses menggunakan Bahasa Indonesia.

## Kebutuhan
- Windows + XAMPP (PHP 8.2+) dan MySQL/MariaDB aktif
- Composer, Node.js, npm
- Ekstensi PHP wajib Laravel: `mbstring`, `dom`/`xml`, `pdo_mysql`, `fileinfo`, `openssl` dll.

## Menjalankan di XAMPP (project fresh)
1. Ekstrak ke `C:\xampp\htdocs\jamplus` atau folder project pilihan.
2. Buka XAMPP Control Panel: nyalakan **Apache** dan **MySQL**.
3. Buka phpMyAdmin dan buat database kosong `jamplus` (kolasi `utf8mb4_unicode_ci`).
4. Terminal di root folder `jamplus`:

```powershell
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

5. Kunjungi `http://127.0.0.1:8000`.

> **Penting:** `migrate:fresh` menghapus seluruh tabel dalam database target! Gunakan **hanya untuk database baru/kosong** atau setelah membuat backup. Jika database `jamplus` sudah berisi data penting, gunakan `php artisan migrate --seed` setelah memeriksa status tabel. Tidak perlu mengimpor `jamplus.sql` apabila memilih pendekatan migration.

### Database
Migrations mereplikasi 9 tabel di `jamplus.sql` tanpa tabel tambahan. `.env.example` disetel ke MySQL database `jamplus`, user `root`, password kosong, serta session/cache file dan queue sync.

Jika lebih memilih **impor SQL lewat phpMyAdmin** (bukan migration): impor `jamplus.sql` ke database kosong, lalu jalankan `php artisan db:seed`; jangan menjalankan `migrate:fresh` setelah impor, karena akan menghapus tabel yang baru diimpor.

### Akun demo (setelah seeder)
- Admin prodi P01: `sekprod.p01@kampus.test` / `Jamplus123!`
- Admin prodi P02–P09: `sekprod.p02@kampus.test` dst / `Jamplus123!`
- Mahasiswa P01: `p01001@mahasiswa.test` / `P01001`
- Mahasiswa lainnya: `p01002@mahasiswa.test` / `P01002`, dan pola serupa P02–P09.

Semua password ini **hanya untuk pengembangan**, wajib diganti untuk deployment nyata. Nama 9 prodi masih placeholder `Program Studi P01` sampai `P09` dan perlu diganti sesuai data kampus yang benar.

## Alur utama
1. Login admin untuk membuat event, mengatur kategori dan memberi akses pembuat acara.
2. Admin atau mahasiswa dengan akses aktif membuat event dan publikasi ke beranda.
3. Mahasiswa mendaftar; pembuat acara/admin prodi menyetujui pendaftaran dengan cek kuota dalam transaksi.
4. Setelah acara selesai, mahasiswa yang approved mengunggah bukti gambar/PDF ke penyimpanan **private**.
5. Pembuat acara/admin prodi memverifikasi bukti; bila approved, reward dibuat/di-update, bila ditolak setelah approved, reward dihapus dalam transaksi.
6. Mahasiswa melihat riwayat dan total reward, admin memantau mahasiswa prodinya.

## Halaman
- `/login` — login tanpa registrasi mandiri
- `/dashboard` — dasbor berbeda untuk admin dan mahasiswa
- `/jelajah` — kartu event, pencarian/filter/paginasi
- `/riwayat` dan `/progres` — histori dan reward mahasiswa
- `/kelola-event` — buat, edit, batal event; peserta dan verifikasi
- `/admin/pending`, `/admin/mahasiswa`, `/admin/akses`, `/admin/kategori` — modul admin

## Pengujian
```powershell
php artisan test
```
Termasuk tes fondasi database dan tes workflow (kuota, reward, akses lintas prodi). Tes memerlukan PHP CLI dengan ekstensi yang tersedia dan database pengujian yang aman. Jangan arahkan test dengan `RefreshDatabase` ke database produksi.

## Catatan implementasi
- Skema dari `jamplus.sql` tidak diubah.
- Akun admin dan mahasiswa terikat ke prodi masing-masing.
- Penyimpanan reward memakai baris `student_rewards`, bukan kolom total baru.
- Poster tersimpan di `public` disk, sedangkan bukti kehadiran hanya tersedia lewat route otorisasi.
- CSS hasil build telah disertakan di `public/build` untuk tampilan awal.
- Untuk perubahan frontend berikutnya, jalankan kembali `npm run build`.

## Batasan verifikasi pada sesi ini
Pemeriksaan PHP syntax dan registrasi route dilakukan. Tes PHPUnit dan uji koneksi MySQL sungguhan belum dapat dijalankan pada environment pembuatan karena tidak tersedia ekstensi PHP `dom`, `mbstring`, `xmlwriter`, juga server MySQL/XAMPP milik pengguna tidak bisa diakses dari sini. Jalankan perintah pengujian pada mesin XAMPP Anda.

## Tambahan: Master User (role super_admin)

Versi ini menambah **satu nilai enum** ke kolom `users.role`, yaitu `super_admin` (dua role lama tetap ada). Tidak ada tabel/kolom baru. `study_program_id` tetap wajib karena sesuai skema SQL asli; akun super admin contoh terikat ke P01 untuk memenuhi FK tetapi mengelola semua prodi. Admin prodi tetap hanya mengelola prodinya.

### Upgrade project lama tanpa menghapus data

1. **Backup database `jamplus`** melalui phpMyAdmin terlebih dahulu.
2. Timpa file project menggunakan ZIP yang baru (jaga `.env` dan file upload milikmu), atau gunakan versi source untuk merge.
3. Buka CMD pada folder project, lalu jalankan:

```bat
composer dump-autoload
php artisan optimize:clear
php artisan migrate
php artisan db:seed
php artisan route:list --path=master
php artisan serve
```

**Jangan menjalankan `php artisan migrate:fresh` pada database yang sudah memiliki data**, karena akan menghapus tabel dan isinya. Migration tambahan `2026_11_18_000001_add_super_admin_role_to_users.php` mengubah tipe enum `users.role` menjadi `admin`, `mahasiswa`, `super_admin`, tanpa menghapus baris user lama. `db:seed` menggunakan `firstOrCreate`; akun yang sudah ada tidak ditimpa password-nya.

Jika sebelumnya database dibuat langsung dengan import `jamplus.sql`, bukan dengan migration Laravel, pastikan histori migration awal sudah sesuai sebelum menjalankan `migrate` agar tidak mencoba membuat ulang sembilan tabel. Jangan pakai `migrate:fresh` sebagai jalan pintas.

### Akun seed untuk pengujian

| Akses | Email | Password **saat pertama kali di-seed** |
| --- | --- | --- |
| Super Admin (baru) | `superadmin@kampus.test` | `Jamplus123!` |
| Admin P01 | `sekprod.p01@kampus.test` | `Jamplus123!` |
| Admin P02–P09 | `sekprod.p02@kampus.test` s.d. `sekprod.p09@kampus.test` | `Jamplus123!` |
| Mahasiswa P01 | `p01001@mahasiswa.test` | `P01001` |
| Mahasiswa P01 lain | `p01002@mahasiswa.test` | `P01002` |

Mahasiswa lainnya mengikuti format `p02001@mahasiswa.test` s.d. `p09002@mahasiswa.test`, password awal = NIM (`P02001`, dst.). Akun ini **baru dijamin dibuat jika seeder berhasil dijalankan**. Jika akun lama pernah diubah, `db:seed` tidak akan mengembalikan password lamanya.

Setelah login super admin, menu **Master User** atau URL `/master/users` berisi tambah user, edit profil & role, filter prodi/role/status, aktif/nonaktif, dan reset password. Penghapusan permanen tidak disediakan karena user dapat memiliki histori event, pendaftaran, dan reward; gunakan nonaktifkan. Super admin aktif terakhir tidak dapat dinonaktifkan atau diturunkan role-nya.

**Keamanan:** akun dan password seed adalah untuk development, bukan production. Ubah password demo sebelum deployment. Hak akses diperiksa pada controller, bukan hanya di menu.

### Frontend assets

Di Windows/XAMPP, setelah upgrade jalankan `npm install` lalu `npm run build` supaya kelas Tailwind halaman Master User ikut terkompilasi. ZIP lengkap menyertakan `vendor` PHP, tetapi **tidak** menyertakan `node_modules` lintas OS. Build frontend di environment pembuat ZIP ini tidak berhasil karena optional binary Rollup Linux tidak tersedia; lakukan build di Windows.
