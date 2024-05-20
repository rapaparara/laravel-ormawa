# SiOrmawa - Sistem Administrasi Ormawa Universitas Negeri Gorontalo

Selamat datang di SiOrmawa! Ini adalah aplikasi sistem administrasi yang dibangun khusus untuk Universitas Negeri Gorontalo, menyediakan berbagai fitur penting untuk kemahasiswaan dan organisasi mahasiswa (Ormawa). Dengan menggunakan teknologi Laravel, Livewire, dan styling dengan Tailwind CSS menggunakan template Flowbite, SiOrmawa hadir untuk memudahkan proses administrasi dan manajemen kegiatan Ormawa.

## Fitur Utama
- **Peminjaman Fasilitas**: Memungkinkan Ormawa untuk melakukan peminjaman fasilitas fakultas secara online.
- **Pencatatan Kegiatan**: Menyediakan fitur pencatatan kegiatan Ormawa untuk dokumentasi dan evaluasi.
- **Manajemen Kepengurusan**: Mempermudah dalam pencatatan dan pembaruan data kepengurusan Ormawa.
- **Manajemen Anggota**: Memberikan fasilitas untuk mencatat dan mengelola data anggota Ormawa.

## Teknologi yang Digunakan
- **Laravel**: Sebagai framework utama untuk pengembangan aplikasi web.
- **Livewire**: Digunakan untuk membuat fitur-fitur interaktif tanpa perlu menulis JavaScript.
- **Tailwind CSS**: Untuk styling aplikasi dengan desain yang responsif dan modern.
- **Flowbite Template**: Menggunakan template Flowbite untuk tata letak yang konsisten dan estetika yang menarik.

## Instalasi
1. Pastikan telah terinstall PHP, Composer, dan Node.js di komputer Anda.
2. Clone repositori ini ke dalam direktori lokal Anda.
git clone https://github.com/namarepositori.git
3. Masuk ke direktori proyek dan jalankan perintah:
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
4. Konfigurasi file `.env` dengan mengisi detail database.
5. Jalankan migrasi database:
php artisan migrate
6. Jalankan aplikasi:
php artisan serve
## Kontribusi
Kami sangat terbuka terhadap kontribusi dari berbagai pihak untuk pengembangan SiOrmawa. Untuk berkontribusi, silakan buat *pull request* ke repositori ini.

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

## Kontak
Jika Anda memiliki pertanyaan atau masukan, jangan ragu untuk menghubungi kami melalui email di [admin@rapyhy.site](mailto:admin@rapyhy.site).

Terima kasih telah menggunakan SiOrmawa! Semoga aplikasi ini membantu meningkatkan efisiensi dan efektivitas kegiatan Ormawa di Universitas Negeri Gorontalo. 🚀
