BLUEPRINT SISTEM MANAJEMEN E-LEARNING & SEKOLAH
1. Spesifikasi Teknologi & Arsitektur Sistem
Pengembangan akan menggunakan pendekatan monolith modern dengan ekosistem murni Laravel, memastikan performa tinggi, keamanan standar industri, dan kemudahan pemeliharaan.

Backend Framework: Laravel 11.x (PHP 8.2+).

Database: MySQL 8.0 atau PostgreSQL 15.

Frontend Engine: Laravel Blade (Server-Side Rendering).

Styling & UI: Tailwind CSS atau Bootstrap 5 (dipilih untuk menghasilkan antarmuka yang kaku, formal, bersih, dan konsisten ala enterprise).

Minimal JavaScript: Alpine.js (untuk interaktivitas ringan seperti dropdown, modal, tabs, tanpa mengubah esensi pure Laravel) dan SweetAlert2 (untuk notifikasi yang smooth).

Package Eksternal Utama:

spatie/laravel-permission: Manajemen Role dan Permission.

maatwebsite/excel: Export/Import data Excel.

barryvdh/laravel-dompdf: Pembuatan dokumen PDF (Raport, Laporan).

yajra/laravel-datatables: Menangani data ribuan baris dengan server-side rendering yang cepat dan responsif.

SDK Payment Gateway (Midtrans / Xendit): Integrasi pembayaran SPP otomatis.

2. Standar Antarmuka (UI/UX)
Sesuai dengan kebutuhan tampilan yang clear, formal, kaku, namun responsif dan smooth:

Layout: Sidebar navigasi di kiri (dapat di-collapse), Header (menampilkan tahun ajaran aktif, profil, notifikasi), dan Main Content Area dengan Card-based layout.

Skema Warna: Biru Navy sebagai warna primer (memberikan kesan institusional dan formal), abu-abu terang untuk background, dan putih murni untuk container data.

Tipografi: Font sans-serif yang tegas seperti Inter atau Plus Jakarta Sans.

Interaksi: Transisi elemen (seperti hover pada tabel atau tombol) diatur pada 0.2s ease-in-out agar terasa mengalir (smooth) tanpa animasi berlebihan.

3. Struktur Database Inti (Relasi Entitas)
Sistem ini membutuhkan skema database yang sangat ternormalisasi. Berikut adalah kelompok tabel utama yang wajib dibuat:

A. Core & Authentication
users: ID, nama, email, password, role_id, status_aktif.

roles & permissions (disediakan oleh Spatie).

user_profiles: Data spesifik (alamat, no_hp, kontak_darurat).

B. Master Data Akademik
academic_years: ID, tahun (cth: 2026/2027), semester (Ganjil/Genap), status (aktif/tidak).

majors: ID, nama_jurusan (IPA, IPS, dll).

classrooms: ID, nama_kelas, wali_kelas_id, major_id.

subjects: ID, kode_mapel, nama_mapel, kkm.

C. Relasi User & Akademik
student_classroom: Pivot murid ke kelas berdasarkan tahun ajaran.

teacher_subject: Pivot guru ke mata pelajaran dan kelas yang diampu.

parents: Data wali murid, relasi parent_student untuk menghubungkan ke users (murid).

D. E-Learning & Evaluasi
materials: ID, teacher_id, subject_id, classroom_id, judul, tipe (PDF/Video/Link), file_path, urutan.

assignments: ID, judul, deskripsi, attachment_path, tenggat_waktu (deadline), status.

submissions: ID, assignment_id, student_id, file_jawaban, waktu_kumpul, nilai, feedback_guru.

exams: ID, judul, tipe (PG/Essay), durasi_menit, waktu_mulai, waktu_selesai.

questions: ID, exam_id, teks_soal, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar, bobot_nilai.

exam_results: ID, exam_id, student_id, skor_total.

E. Penilaian & Keuangan
attendances: ID, student_id, classroom_id, tanggal, status (H/S/I/A), bukti_surat.

grades: ID, student_id, subject_id, tipe_nilai (UH/UTS/UAS), skor, academic_year_id.

invoices: ID, student_id, bulan_tagihan, nominal, status (Lunas/Belum), payment_gateway_url.

transactions: ID, invoice_id, metode_pembayaran, tanggal_bayar, status_transaksi.

4. Penjabaran Modul & Hak Akses (Berdasarkan Role)
👑 Super Admin (Full Access & Configuration)
Super Admin bertindak sebagai pengendali seluruh operasional sistem.

Manajemen Master Data:

Identitas Sekolah: Form input nama, logo, alamat, dan kontak resmi sekolah.

Tahun Ajaran: CRUD tahun ajaran. Sistem menggunakan flagging is_active untuk menentukan tahun ajaran berjalan.

Kelas & Jurusan: CRUD jurusan, pembuatan kelas, dan penunjukan Wali Kelas.

Kalender Akademik: Modul kalender (menggunakan library FullCalendar) untuk menandai hari libur, ujian, dan acara sekolah.

Manajemen User (CRUD Terpusat):

Guru: Input NIP, nama, kontak, dan assign ke mata pelajaran tertentu menggunakan multiselect form.

Murid: Input NISN, nama, dan assign ke kelas. Terdapat fitur Import via Excel untuk memasukkan ratusan data murid sekaligus.

Wali Murid: Integrasi data orang tua yang dilink langsung ke ID murid.

Aksi Cepat: Reset password (kembali ke default), toggle aktif/non-aktif akun tanpa menghapus data (soft deletes).

Akademik & Laporan:

Bobot Nilai: Antarmuka untuk mengatur persentase (Contoh: UH 30%, Tugas 20%, UTS 20%, UAS 30%).

Raport: Fitur Generate Raport Massal. Sistem mengambil data dari tabel grades, menghitung secara otomatis, dan memformatnya ke dalam template PDF.

Rekap: Tabel DataTables yang menampilkan rekap nilai dan absensi seluruh kelas dengan filter tahun ajaran dan kelas.

Keuangan (SPP):

Pembuatan Invoice otomatis setiap tanggal 1 per bulan berdasarkan pengaturan nominal SPP per kelas.

Tabel monitoring pembayaran real-time (sinkronisasi dengan webhook payment gateway).

Cetak rekap keuangan bulanan/tahunan (Export ke PDF/Excel).

Konfigurasi Sistem:

Log Aktivitas: Merekam setiap aksi penting (siapa, melakukan apa, kapan, IP address).

Backup & Restore: Tombol eksekusi command artisan untuk backup database.

👨‍🏫 Guru (Manajer Kelas & Evaluator)
Akses guru dibatasi secara ketat hanya pada kelas dan mata pelajaran yang diampunya (diatur melalui query scopes di Laravel).

E-Learning & Materi:

Manajemen Modul: Guru dapat membuat Bab, lalu mengunggah file. Sistem harus memiliki validasi ekstensi (PDF, PPT, MP4) dan pembatasan ukuran file.

Perpustakaan: Direktori arsip materi dari tahun ajaran sebelumnya yang bisa di-clone ke tahun ajaran saat ini.

Tugas & Ujian (CBT Module):

Distribusi Tugas: Pembuatan form tugas yang otomatis memunculkan notifikasi di dashboard murid terkait.

Bank Soal & Ujian: Antarmuka pembuatan soal PG/Essay. Guru menentukan durasi (menit) dan waktu buka/tutup akses ujian.

Auto-Koreksi: Untuk soal Pilihan Ganda, setelah waktu ujian murid habis, sistem langsung mencocokkan jawaban dan mengeksekusi insert skor ke tabel exam_results.

Koreksi Manual: Form khusus untuk membaca jawaban essay murid dan memberikan nilai serta komentar.

Penilaian & Raport Kelas:

Tabel input nilai seperti spreadsheet Excel. Guru menginput nilai UH/UTS/UAS.

Kalkulator otomatis akan menjumlahkan nilai sesuai bobot yang diatur Super Admin.

Absensi:

Halaman absensi harian. Guru melakukan checkbox status (H/S/I/A). Jika 'Sakit' atau 'Izin', guru dapat melihat lampiran surat dari murid.

Komunikasi & Jadwal:

Fitur pengumuman yang dikirim ke kelas tertentu.

Tabel jadwal mengajar pribadi yang otomatis ditarik dari Master Data.

🎒 Murid (Pengguna Akhir / Pembelajar)
Antarmuka murid difokuskan pada kejelasan informasi (tugas apa yang harus dikerjakan hari ini, status pembayaran, jadwal).

Dashboard Utama:

Panel ringkasan: Jadwal hari ini, jumlah tugas tertunda (badge merah jika overdue), dan pengumuman terbaru.

E-Learning:

Daftar mata pelajaran berbentuk grid cards. Saat diklik, menampilkan timeline bab dan materi.

Fitur mark as done (tandai selesai dibaca) yang memberikan indikator persentase progress belajar.

Tugas & Ujian:

Area Pengumpulan: Form unggah file dengan pembatasan tipe dokumen.

Ujian Live: Halaman ujian dengan desain minimalis. Terdapat timer berbasis JavaScript (berjalan sinkron dengan server time untuk menghindari manipulasi lokal). Jika waktu habis, form otomatis submit.

Halaman Review hasil ujian (opsional, tergantung pengaturan guru apakah pembahasan dibuka).

Nilai & Raport:

Tabel transkrip nilai per semester.

Grafik garis (menggunakan library ringan seperti Chart.js) untuk melihat tren nilai dari bulan ke bulan.

Tombol unduh Raport Digital (PDF).

Absensi:

Formulir pengajuan izin/sakit. Murid wajib mengunggah foto surat dokter/keterangan yang nantinya akan divalidasi oleh guru.

Pembayaran SPP:

Daftar tagihan. Jika tagihan belum lunas, terdapat tombol "Bayar Sekarang".

Proses checkout dialihkan secara smooth ke halaman payment gateway (Qris, Virtual Account, Retail).

Riwayat pembayaran lengkap dengan resi unduhan digital.

5. Standar Eksekusi Kode (Pure Laravel Best Practices)
Untuk memastikan sistem formal, kaku, smooth, dan responsif, aturan kode berikut harus diterapkan:

Form Requests: Jangan lakukan validasi di Controller. Selalu gunakan php artisan make:request untuk menjaga controller tetap bersih dan memastikan struktur input valid.

Service Pattern: Logika bisnis yang berat (seperti kalkulasi nilai akhir raport, atau logika auto-koreksi ujian) dipisahkan ke folder app/Services/. Controller hanya bertugas menerima input dan mengembalikan view.

Eager Loading: Untuk mencegah masalah query N+1 (misal memanggil data murid beserta nilainya), wajib menggunakan method with().

Contoh salah: Student::all(); lalu memanggil $student->grades di Blade.

Contoh benar: Student::with('grades', 'classroom')->get();.

Database Transactions: Untuk proses krusial seperti pembayaran SPP atau pengumpulan jawaban ujian multitable, gunakan DB::transaction(). Jika ada satu query gagal, seluruh proses dibatalkan (rollback) untuk mencegah data korup.

Route Grouping: Kelompokkan routes berdasarkan middleware role:

PHP
Route::middleware(['auth', 'role:super-admin'])->prefix('admin')->group(function () {
    // Rute khusus admin
});