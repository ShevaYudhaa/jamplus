# Laporan Tahap 2

Tahap 2 selesai. Tahap 3 belum dimulai; middleware/policy role dan akses pembuat acara belum dibuat.

## Hasil

- Memakai Laravel 12.71.0 dan Breeze Blade/Tailwind yang sudah terpasang. Tidak menambah package.
- Migrations untuk 9 tabel aplikasi mengikuti jamplus.sql. Laravel memakai tabel teknis migrations.
- Model seluruh tabel, relasi dua arah, serta casts enum, tanggal, boolean, dan decimal.
- MySQL jamplus dengan root/password kosong; session/cache file, queue sync, locale id, timezone Asia/Jakarta.
- Seeder idempotent: 9 prodi placeholder P01–P09, 9 admin, 18 mahasiswa, 6 kategori. Data dan password yang telah disunting dipertahankan saat seed ulang.
- Scaffold Breeze disesuaikan dengan skema: login/logout dasar, tanpa registrasi mandiri, remember me, verifikasi email, dan reset password via email. Scaffold profil mandiri dan penghapusan akun bawaan dilepas karena tidak termasuk alur brief.
- Route penyajian otomatis disk private dinonaktifkan; route bukti dengan otorisasi dibuat pada tahap 6.
- Halaman login dan dasbor awal dalam Bahasa Indonesia. Tampilan dan fitur lengkap mengikuti tahap berikutnya.

## Pemeriksaan yang dijalankan

| Pemeriksaan | Hasil |
| --- | --- |
| Jumlah awal seluruh tabel aplikasi | Seluruhnya 0, diperiksa dengan COUNT sebelum fresh |
| php artisan migrate:fresh --seed | Percobaan pertama gagal; percobaan kedua berhasil |
| Perbandingan skema MySQL sebelum/sesudah | 168 baris metadata cocok: kolom/urutan/tipe/null/default/comment, indeks, FK/kolom referensi/aksi, engine dan collation |
| php artisan db:seed | Berhasil; tetap 9 prodi, 9 admin, 18 mahasiswa, 6 kategori |
| php artisan test | Hasil akhir 14 lulus, 84 assertion; menggunakan SQLite :memory: terpisah dari MySQL lokal |
| npm.cmd run build | Berhasil |
| php artisan route:list | Berhasil; 6 route termasuk /up; route register/reset/verifikasi email tidak ada |
| php artisan migrate:status | Migration skema tercatat Ran |
| php artisan storage:link | Melaporkan link sudah ada; junction diperiksa dan mengarah ke storage/app/public yang benar |
| HTTP pada server Laravel dengan MySQL lokal | Login admin, login mahasiswa, dasbor, logout, CSS, dan JS berhasil HTTP 200 |
| git diff --check | Lulus |

Login dan aset diperiksa lewat HTTP, belum melalui inspeksi visual browser. Server sementara untuk pemeriksaan dihentikan setelah selesai.

### Kegagalan awal dan penyelesaiannya

1. Fresh pertama menghasilkan pesan: `SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'study_programs' already exists`. Database awal berasal dari import SQL tanpa tabel migrations. Kode Laravel FreshCommand melewati wipe jika repository migrations belum ada. Percobaan tersebut membuat repository; perintah yang sama kemudian dijalankan ulang dan berhasil. Tidak mengubah vendor atau mengabaikan tabel lama.
2. Test pertama: 13 lulus, 1 gagal karena daftar tabel SQLite memakai awalan main. Pemeriksaan diubah memakai `Schema::getTableListing(schemaQualified: false)`; hasil akhir semuanya lulus.
3. Pesan storage: `The [C:\xampp\htdocs\Sistem Informasi Monitoring Jam Plus dan Soft Skill Mahasiswa\jamplus\public\storage] link already exists.` Link yang sudah ada valid, sehingga tidak diganti.

## Cara mencoba

Jalankan dari folder jamplus; aktifkan MySQL XAMPP:

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Buka http://127.0.0.1:8000/login.

| Akun contoh | Email | Password awal |
| --- | --- | --- |
| Admin P01 | sekprod.p01@kampus.test | Jamplus123! |
| Mahasiswa P01 | p01001@mahasiswa.test | P01001 |

Admin P02–P09 memakai pola email yang sama. Mahasiswa dummy tiap prodi bernomor 001 dan 002; password awal sama dengan NIM, misalnya P01002.

Setelah login, dasbor awal menampilkan nama dan prodi. Tombol Keluar mengakhiri sesi. /register, /forgot-password, serta /verify-email menghasilkan 404.

Pemeriksaan terminal yang dapat diulang:

```powershell
php artisan test
php artisan route:list
php artisan migrate:status
php artisan db:seed
npm.cmd run build
```

`php artisan migrate:fresh --seed` telah diuji pada database kosong. Perintah ini menghapus seluruh tabel dan data; gunakan hanya ketika database memang boleh direset.

## Keputusan yang masih menunggu tahap terkait

- Kode/nama 9 prodi asli sebelum finalisasi; saat ini placeholder sesuai brief.
- Hak pengelolaan event lama setelah akses pembuat acara dicabut (tahap 3).
- Wewenang admin atas kategori global; perubahan penawaran setelah reward terbit; hapus permanen versus pembatalan event; transisi status dan perlakuan event cancelled (tahap 4–7).

## Daftar seluruh file sumber yang berubah

AGENT_BRIEF.md dan jamplus.sql sudah ada sebelum pekerjaan ini dan tidak diubah. .env tidak tercatat Git, tetapi konfigurasinya diperbarui. public/build berisi hasil build yang diabaikan Git; public/storage sudah ada sebelumnya.

| Status | File |
| --- | --- |
| Diubah (diabaikan Git) | .env |
| Diubah | .env.example |
| Dihapus | app/Http/Controllers/Auth/ConfirmablePasswordController.php |
| Dihapus | app/Http/Controllers/Auth/EmailVerificationNotificationController.php |
| Dihapus | app/Http/Controllers/Auth/EmailVerificationPromptController.php |
| Dihapus | app/Http/Controllers/Auth/NewPasswordController.php |
| Dihapus | app/Http/Controllers/Auth/PasswordController.php |
| Dihapus | app/Http/Controllers/Auth/PasswordResetLinkController.php |
| Dihapus | app/Http/Controllers/Auth/RegisteredUserController.php |
| Dihapus | app/Http/Controllers/Auth/VerifyEmailController.php |
| Dihapus | app/Http/Controllers/ProfileController.php |
| Diubah | app/Http/Requests/Auth/LoginRequest.php |
| Dihapus | app/Http/Requests/ProfileUpdateRequest.php |
| Diubah | app/Models/User.php |
| Diubah | config/app.php |
| Diubah | config/cache.php |
| Diubah | config/database.php |
| Diubah | config/filesystems.php |
| Diubah | config/queue.php |
| Diubah | config/session.php |
| Diubah | database/factories/UserFactory.php |
| Dihapus | database/migrations/0001_01_01_000000_create_users_table.php |
| Dihapus | database/migrations/0001_01_01_000001_create_cache_table.php |
| Dihapus | database/migrations/0001_01_01_000002_create_jobs_table.php |
| Diubah | database/seeders/DatabaseSeeder.php |
| Dihapus | resources/views/auth/confirm-password.blade.php |
| Dihapus | resources/views/auth/forgot-password.blade.php |
| Diubah | resources/views/auth/login.blade.php |
| Dihapus | resources/views/auth/register.blade.php |
| Dihapus | resources/views/auth/reset-password.blade.php |
| Dihapus | resources/views/auth/verify-email.blade.php |
| Diubah | resources/views/dashboard.blade.php |
| Diubah | resources/views/layouts/navigation.blade.php |
| Dihapus | resources/views/profile/edit.blade.php |
| Dihapus | resources/views/profile/partials/delete-user-form.blade.php |
| Dihapus | resources/views/profile/partials/update-password-form.blade.php |
| Dihapus | resources/views/profile/partials/update-profile-information-form.blade.php |
| Dihapus | resources/views/welcome.blade.php |
| Diubah | routes/auth.php |
| Diubah | routes/web.php |
| Diubah | tests/Feature/Auth/AuthenticationTest.php |
| Dihapus | tests/Feature/Auth/EmailVerificationTest.php |
| Dihapus | tests/Feature/Auth/PasswordConfirmationTest.php |
| Dihapus | tests/Feature/Auth/PasswordResetTest.php |
| Dihapus | tests/Feature/Auth/PasswordUpdateTest.php |
| Diubah | tests/Feature/Auth/RegistrationTest.php |
| Diubah | tests/Feature/ExampleTest.php |
| Dihapus | tests/Feature/ProfileTest.php |
| Ditambah | app/Enums/AudienceScope.php |
| Ditambah | app/Enums/EventStatus.php |
| Ditambah | app/Enums/RegistrationStatus.php |
| Ditambah | app/Enums/RewardType.php |
| Ditambah | app/Enums/UserRole.php |
| Ditambah | app/Enums/VerificationStatus.php |
| Ditambah | app/Models/AttendanceVerification.php |
| Ditambah | app/Models/Event.php |
| Ditambah | app/Models/EventCategory.php |
| Ditambah | app/Models/EventCreatorAccess.php |
| Ditambah | app/Models/EventRegistration.php |
| Ditambah | app/Models/EventTargetProgram.php |
| Ditambah | app/Models/StudentReward.php |
| Ditambah | app/Models/StudyProgram.php |
| Ditambah | database/factories/StudyProgramFactory.php |
| Ditambah | database/migrations/2026_11_11_000000_create_jamplus_tables.php |
| Ditambah | lang/id/auth.php |
| Ditambah | lang/id/validation.php |
| Ditambah | tests/Feature/DatabaseFoundationTest.php |
| Ditambah | TAHAP_2.md |
