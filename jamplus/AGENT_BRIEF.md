# Brief Proyek: Sistem Informasi Monitoring Jam Plus & Soft Skill Mahasiswa

Dokumen ini adalah instruksi lengkap untuk membangun aplikasinya. **Baca seluruhnya sebelum menulis kode apa pun.**

---

## 0. LANGKAH PERTAMA (WAJIB): Baca database

Skema database sudah dirancang dan **sudah ada di folder project** sebagai file `.sql`.

1. Cari file `jamplus.sql` di project (kemungkinan di `database/` atau root). Kalau tidak ketemu, jalankan pencarian `*.sql` dan `*.dbml`.
2. **Baca isi file SQL itu sampai habis.** File tersebut adalah **sumber kebenaran (source of truth)** untuk nama tabel, nama kolom, tipe data, enum, foreign key, dan perilaku `ON DELETE`.
3. Jika ada file `jamplus.dbml`, itu versi diagram yang setara; gunakan hanya sebagai referensi tambahan.
4. **Jangan mengubah, menambah, atau mengganti nama tabel/kolom** tanpa bertanya dulu kepada saya. Seluruh keputusan skema sudah final (lihat bagian 11 untuk hal yang sengaja tidak dimasukkan).
5. Setelah membaca, tulis ringkasan singkat pemahamanmu tentang skema (daftar tabel dan relasi utamanya) untuk saya konfirmasi sebelum lanjut ke tahap berikutnya.

Skema berisi 9 tabel: `study_programs`, `users`, `event_creator_access`, `event_categories`, `events`, `event_target_programs`, `event_registrations`, `attendance_verifications`, `student_rewards`.

---

## 1. Ringkasan produk

Aplikasi seperti "LinkedIn tapi untuk event kampus". Kalau LinkedIn untuk mencari pekerjaan, ini untuk mencari **event kampus** yang memberi **reward berupa Jam Plus dan/atau poin Soft Skill**.

Kampus punya **9 program studi**. Admin = **Sekretaris Prodi (sekprod)** masing-masing prodi. Karena kebanyakan event berasal dari himpunan mahasiswa, sekprod bisa **memberi akses "pembuat acara"** kepada mahasiswa tertentu (biasanya sekretaris himpunan), supaya sekprod tidak perlu menginput semua event. Admin juga tetap bisa membuat event sendiri.

**Scope sengaja dikecilkan.** Aplikasi TIDAK mencetak PDF/sertifikat/form Jam Plus. Pemberian reward di dunia nyata dilakukan mahasiswa dengan menghubungi dosen/panitia terkait. Sistem hanya mencatat dan memverifikasi.

---

## 2. Tech stack

- **Laravel 11 atau 12** (PHP 8.2+), berjalan di **XAMPP** dengan **MySQL/MariaDB**
- **Laravel Breeze** (Blade + Tailwind) untuk autentikasi
- Frontend: Blade + Tailwind. Tidak perlu SPA. Alpine.js boleh bila perlu.
- Jangan pakai `spatie/permission`. Role cukup dari kolom `users.role`, ditambah middleware/policy.
- Hindari package tambahan kecuali benar-benar perlu. Tanyakan dulu.

Catatan environment (jaringan sering bermasalah ke packagist): kalau `composer` timeout, beri tahu saya, jangan mencoba workaround aneh.

---

## 3. Setup & integrasi database

Pilih satu pendekatan dan jelaskan alasannya sebelum mengerjakan:

- **Disarankan:** buat **Laravel migrations** yang **mereplikasi persis** skema di file SQL (nama tabel, kolom, tipe, enum, unique, index, FK, aksi `ON DELETE/UPDATE`). Setelah itu pastikan `php artisan migrate:fresh --seed` berjalan bersih.
- Atau gunakan database yang sudah diimport dari SQL, lalu buat Model saja. Jika begitu, pastikan tidak ada konflik dengan migration bawaan Laravel.

Penting:

- `.env`: `DB_DATABASE=jamplus`, `DB_USERNAME=root`, `DB_PASSWORD=` (kosong).
- Set `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync` agar **tidak perlu tabel tambahan** (`sessions`, `cache`, `jobs`) yang tidak ada di skema.
- Tabel `users` di skema **tidak punya** kolom `remember_token`, `email_verified_at`, atau `password_reset_tokens`. Sesuaikan Breeze: nonaktifkan "remember me", verifikasi email, dan reset password lewat email (atau tanyakan kepada saya kalau perlu ditambahkan). **Jangan diam-diam menambah kolom.**
- Login memakai **email + password**.
- Jalankan `php artisan storage:link` untuk upload poster.

---

## 4. Role & hak akses

Hanya ada dua nilai `users.role`: **`admin`** dan **`mahasiswa`**. **Jangan menambah role baru.**

Setiap user (termasuk admin) terikat ke satu prodi lewat `users.study_program_id` (NOT NULL). Jadi admin = sekprod dari prodi tersebut, dan hanya boleh mengelola data prodinya sendiri.

### Admin (sekprod)

- Login, dashboard monitoring prodinya.
- Membuat, mengedit, dan membatalkan event.
- Menyetujui/menolak pendaftaran serta memverifikasi kehadiran untuk event yang `organizer_program_id`-nya adalah prodinya, **atau** event yang dia buat sendiri.
- Memberi dan mencabut **akses pembuat acara** kepada mahasiswa **di prodinya**.
- Melihat daftar mahasiswa prodinya dengan total Jam Plus dan Soft Skill.
- Mengelola `event_categories`.

### Mahasiswa

- Melihat beranda event, mencari/memfilter, melihat detail.
- Mendaftar event, membatalkan pendaftaran, upload bukti kehadiran, melihat riwayat dan total reward sendiri.
- **Jika punya akses pembuat acara aktif** (baris `event_creator_access` dengan `is_active = 1`): juga boleh membuat event dan mengelola event miliknya sendiri, termasuk menyetujui pendaftaran dan memverifikasi kehadiran peserta event tersebut. Menu "Kelola Acara Saya" hanya muncul untuk mahasiswa yang punya akses.

Gunakan **Policy / Gate**, jangan hanya menyembunyikan menu.

---

## 5. Alur utama

1. Admin atau mahasiswa pemegang akses **membuat event** → tampil di beranda mahasiswa saat status `published`.
2. Mahasiswa **mendaftar** → `event_registrations.status = pending`.
3. **Pembuat acara atau admin prodi penyelenggara** menyetujui (`approved`) atau menolak (`rejected`, isi `rejection_notes`).
4. Setelah acara berlangsung, mahasiswa yang `approved` **upload bukti kehadiran** → baris `attendance_verifications` dengan status `pending`.
5. **Pembuat acara atau admin prodi penyelenggara** memverifikasi (`approved`/`rejected` + `verification_notes`).
6. Saat kehadiran `approved`, sistem membuat baris `student_rewards` dan total mahasiswa bertambah.
7. Pemberian reward formal dilakukan di luar sistem (mahasiswa menghubungi dosen/panitia).

---

## 6. Aturan bisnis (WAJIB divalidasi di aplikasi)

Skema **sengaja tidak memakai CHECK constraint**. Semua aturan ini harus ditegakkan di Laravel (Form Request, Policy, atau Service).

### Pembuatan event

- Pemegang akses boleh membuat event **sebanyak apa pun** selama aksesnya aktif, **tanpa approval per event**.
- `organizer_program_id` event buatan mahasiswa **harus** salah satu `study_program_id` dari `event_creator_access` miliknya yang aktif. Untuk admin, `organizer_program_id` = prodinya sendiri.
- `end_at >= start_at`.
- `registration_deadline` (jika diisi) `<= start_at`.
- Kecocokan `reward_type`:
  - `jam_plus` → `jam_plus_offer` wajib terisi (> 0), `soft_skill_points_offer` harus kosong/0.
  - `soft_skill` → `soft_skill_points_offer` wajib terisi (> 0), `jam_plus_offer` harus kosong/0.
  - `both` → keduanya wajib terisi (> 0).
- `audience_scope`:
  - `all` → terbuka untuk semua prodi, `event_target_programs` kosong.
  - `selected` → isi `event_target_programs`; prodi penyelenggara **otomatis ikut dimasukkan**.
- Poster: upload gambar (jpg/png/webp), maksimal 2 MB.
- Status event: `draft → published → closed → completed`, atau `cancelled`. Hanya event `published` yang tampil di beranda mahasiswa.
- Hanya pembuat event atau admin prodi penyelenggara yang boleh mengedit/membatalkan event.

### Pendaftaran

- Mahasiswa hanya bisa mendaftar jika: event `published`, belum lewat `registration_deadline` (atau belum lewat `start_at` bila deadline kosong), prodinya termasuk target (atau scope `all`), dan belum pernah mendaftar (unik `event_id + user_id`).
- Kuota (`quota` null = tanpa batas) dihitung dari pendaftaran berstatus `approved`. **Cek ulang kuota saat approval**, bukan hanya saat mendaftar.
- Mahasiswa boleh membatalkan pendaftaran sendiri (`cancelled`) selama acara belum dimulai.
- Saat approve: isi `approved_by` dan `approved_at`. Saat reject: `rejection_notes` wajib.
- Yang boleh approve/reject: `events.creator_id`, atau admin dengan `study_program_id` = `events.organizer_program_id`. Admin prodi lain **tidak boleh**.

### Bukti kehadiran & verifikasi

- Upload bukti hanya boleh jika pendaftaran `approved` dan acara sudah berakhir (`now() >= end_at`) atau event `completed`.
- Satu pendaftaran hanya punya satu bukti (unik `registration_id`). Jika ditolak, mahasiswa boleh upload ulang (update baris yang sama dan reset ke `pending`).
- Bukti: gambar atau PDF, maksimal 5 MB. Simpan di disk **private** dan sajikan lewat route yang dicek otorisasinya (hanya pemilik, pembuat acara, dan admin prodi penyelenggara).
- Yang boleh verifikasi: sama seperti aturan approve di atas. Isi `verified_by` dan `verified_at`.

### Reward

- `student_rewards` dibuat **hanya** saat `attendance_verifications.verification_status` menjadi `approved`.
- Nilai diambil dari penawaran event:
  - `reward_type = jam_plus` → `jam_plus = jam_plus_offer`, `soft_skill_points = null`
  - `reward_type = soft_skill` → `soft_skill_points = soft_skill_points_offer`, `jam_plus = null`
  - `reward_type = both` → keduanya.
- Jika verifikasi dikoreksi dari `approved` ke `rejected`, **hapus** baris `student_rewards` terkait. Lakukan dalam satu **DB transaction**.
- Total mahasiswa dihitung dengan `SUM` dari `student_rewards`. **Jangan menyimpan kolom total** di tabel mana pun.

### Akses pembuat acara

- Admin hanya boleh memberi akses kepada mahasiswa di **prodinya sendiri**, dan `granted_by` diisi admin tersebut.
- Pencabutan: set `is_active = 0` dan isi `revoked_at`. Jangan hapus barisnya. Event yang sudah dibuat tetap ada.
- Pemberian ulang ke mahasiswa yang sama dan prodi yang sama: aktifkan kembali baris yang ada (ingat unique `user_id + study_program_id`), isi ulang `granted_at`, dan kosongkan `revoked_at`.

---

## 7. Halaman yang dibutuhkan

### Publik/Auth

- Login (Breeze). Registrasi mandiri **dinonaktifkan**; akun dibuat admin atau seeder.

### Mahasiswa

- **Beranda**: kartu event bergaya job-board. Menampilkan poster, judul, penyelenggara, tanggal, lokasi, badge reward (Jam Plus / Soft Skill / keduanya beserta nilainya), sisa kuota. Pencarian teks, filter kategori, filter jenis reward, dan paginasi.
- **Detail event** + tombol Daftar/Batal.
- **Riwayat saya**: daftar pendaftaran dengan status, tombol upload bukti, alasan penolakan jika ada.
- **Progres saya**: total Jam Plus dan total poin Soft Skill, plus rinciannya per event.
- **Kelola Acara Saya** (hanya pemegang akses): CRUD event, daftar peserta per event, approve/reject pendaftaran, verifikasi bukti.

### Admin

- **Dashboard**: jumlah event aktif, pendaftaran pending, verifikasi pending, ringkasan mahasiswa prodi.
- **Event**: CRUD, serta pengelolaan peserta dan verifikasi.
- **Akses Pembuat Acara**: daftar pemegang akses, tombol beri/cabut, cari mahasiswa prodi sendiri.
- **Mahasiswa prodi**: daftar dengan filter angkatan, total Jam Plus dan Soft Skill per mahasiswa, detail riwayat. Import mahasiswa dari Excel/CSV (kolom: NIM, nama, email, angkatan) dengan password awal = NIM (di-hash). Package Excel hanya jika perlu; import CSV tanpa package juga cukup.
- **Kategori event**: CRUD sederhana.

Admin juga perlu satu halaman kecil "Pending" yang mengumpulkan semua pendaftaran dan verifikasi yang menunggu aksi.

---

## 8. Seeder

Buat seeder yang idempotent:

- `study_programs`: **9 prodi**. Gunakan data placeholder dulu (mis. kode `P01` sampai `P09`) dan **tanyakan kepada saya nama prodi sebenarnya** sebelum finalisasi.
- `users`: 9 akun admin (satu per prodi), contoh email `sekprod.<kode>@kampus.test`, password default sementara (beri tahu saya apa passwordnya). Plus beberapa akun mahasiswa dummy per prodi untuk testing.
- `event_categories`: contoh Seminar, Workshop, Lomba, Kepanitiaan, Pengabdian Masyarakat, Organisasi.
- Opsional: beberapa event dan pendaftaran contoh supaya UI langsung terlihat berisi.

---

## 9. Struktur kode yang diharapkan

- Model Eloquent dengan relasi lengkap dan `$casts` untuk enum dan datetime. Boleh pakai PHP Backed Enum untuk enum di skema.
- Policy: `EventPolicy`, `RegistrationPolicy`, `AttendanceVerificationPolicy`.
- Form Request untuk validasi (terutama pembuatan/ubah event).
- Logika yang menyentuh banyak tabel (verifikasi → reward, approval dengan cek kuota) ditaruh di **Service class** dan dibungkus transaction.
- Middleware kecil untuk `admin` dan `event.creator` (atau pakai Gate).
- Controller dipisah per area: `Student/`, `Admin/`, `Creator/` atau pola setara yang konsisten.
- Bahasa UI: **Bahasa Indonesia**. Timezone `Asia/Jakarta`, locale `id`.
- Pesan flash dan validasi dalam Bahasa Indonesia.

---

## 10. Cara kerja yang diharapkan

Kerjakan **bertahap**, dan setelah tiap tahap berikan ringkasan singkat + cara mengetesnya. Berhenti dan tanya bila ada yang ambigu.

1. Baca SQL, konfirmasi pemahaman skema (bagian 0).
2. Setup project, Breeze, `.env`, migrations/model sesuai skema, seeder dasar.
3. Autentikasi + middleware/policy role dan akses pembuat acara.
4. CRUD event (admin dan pembuat acara) + upload poster.
5. Beranda mahasiswa + detail + pendaftaran.
6. Approval pendaftaran, upload bukti, verifikasi, pembuatan reward.
7. Halaman progres mahasiswa + dashboard dan monitoring admin + kelola akses pembuat acara + import mahasiswa.
8. Rapikan UI, pengujian alur utama (feature test untuk aturan bisnis bagian 6), dan tulis `README` singkat cara menjalankan di XAMPP.

---

## 11. Yang SENGAJA tidak dibuat (jangan ditambahkan)

- Tidak ada cetak PDF, sertifikat, atau template form Jam Plus/Soft Skill. Tabel `event_documents` sudah dihapus.
- Tidak ada tabel `jurusan`; skema hanya memakai `study_programs`.
- Tidak ada batas nilai reward per pembuat acara (`max_jam_plus` dan sejenisnya).
- Tidak ada tabel target progres (`progress_targets`); progres cukup menampilkan total, tanpa pembanding target.
- Tidak ada kolom `organizer_name` di `events`.
- Tidak ada CHECK constraint di database; validasi di aplikasi.
- Tidak ada role baru dan tidak ada `spatie/permission`.
- Tidak ada approval per event untuk event buatan pemegang akses.
- Tidak ada tabel jobs/sessions/cache (gunakan driver `file`/`sync`).
- Tidak ada registrasi akun mandiri.

Jika menurutmu ada yang perlu ditambahkan dari daftar ini, **tanyakan dulu** dan jelaskan alasannya. Jangan menambahkan sendiri.
