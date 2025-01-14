# UAS Blangkis

## Identitas Mahasiswa
- **Nama:** Dwi Ramdhona
- **NIM:** A11.2022.14033

## Latar Belakang
Aplikasi Blangkis hadir sebagai solusi digital untuk mendukung UMKM di daerah Blangkon Pakis dalam memperluas akses pasar dan meningkatkan visibilitas produk mereka secara online. UMKM memainkan peran krusial dalam ekonomi lokal dengan menawarkan produk-produk unik yang merefleksikan kekayaan budaya dan kearifan lokal. Namun, pelaku UMKM sering kali menghadapi keterbatasan dalam memasarkan produknya, terutama secara offline, yang membatasi jangkauan mereka. Seiring berkembangnya era digital dan meningkatnya popularitas belanja online, kebutuhan untuk memanfaatkan platform digital sebagai sarana pemasaran menjadi sangat penting agar UMKM tetap kompetitif dan dapat menjangkau konsumen yang lebih luas.

Aplikasi Blangkis dirancang untuk memenuhi kebutuhan tersebut, dengan menyediakan platform yang mempermudah para pelaku UMKM dalam memperkenalkan dan menjual produk mereka. Melalui berbagai fitur yang user-friendly, aplikasi ini memfasilitasi pengguna untuk menjelajahi berbagai produk lokal, melakukan pembelian, dan mendukung proses transaksi dengan aman dan nyaman. Selain itu, aplikasi Blangkis memungkinkan pengguna untuk mengakses informasi produk secara detail dan menyelesaikan transaksi secara langsung, sehingga meningkatkan kemudahan dan efisiensi dalam berbelanja produk UMKM.

Ke depannya, aplikasi Blangkis diharapkan dapat berkembang dengan menambahkan berbagai fitur baru yang lebih dinamis, seperti sistem ulasan pelanggan, notifikasi promosi, dan integrasi metode pembayaran digital yang lebih luas. Dengan terus berinovasi, aplikasi Blangkis diharapkan dapat semakin relevan dan menjadi platform yang esensial bagi UMKM Blangkon Pakis dalam menghadapi tantangan ekonomi digital yang terus berubah.

## Fitur
- User dapat melakukan registrasi akun dan login.
- User dapat melihat daftar produk terbaru di halaman dashboard.
- User dapat memilih produk untuk melihat detail dan menambahkan produk ke daftar pembayaran.
- User dapat melakukan transaksi pembayaran produk yang dipilih.
- User dapat memperbarui profil, username, dan password di halaman profil.
- User dapat mengecek ongkos kirim berdasarkan lokasi tujuan pengiriman.
- User dapat memilih metode pembayaran, seperti manual transfer atau transfer.
- User dapat mengecek history pembelian.

## Teknologi yang Digunakan
- Flutter
- PHP
- MySQL

## Tujuan
Repository ini dibuat untuk menyimpan dan menyediakan hasil Ujian Akhir Semester (UAS) yang dapat diakses dengan mudah dan terorganisasi. Semua file, kode sumber, dan dokumentasi terkait dikumpulkan dalam repository ini untuk memastikan pengelolaan data yang efisien dan transparan.

## Langkah Menjalankan Aplikasi (RUN)
1. **Clone Repository**
   ```bash
   git clone https://github.com/ramdhona/uas-blangkis.git
   cd uas-blangkis
   ```

2. **Setup Backend**
   - Pastikan Anda memiliki server PHP dan MySQL yang terinstal.
   - Buat database baru dengan nama `blangkis_db`.
   - Import file `blangkis_db.sql` yang ada di folder `backend` ke database Anda.
   - Konfigurasi file koneksi database di `backend/config.php` sesuai dengan pengaturan server Anda.

3. **Setup Frontend (Flutter)**
   - Pastikan Flutter SDK sudah terinstal di komputer Anda.
   - Masuk ke folder `frontend`.
   - Jalankan perintah berikut untuk menginstal dependencies:
     ```bash
     flutter pub get
     ```
   - Hubungkan perangkat atau emulator untuk menjalankan aplikasi.
   - Jalankan aplikasi dengan perintah:
     ```bash
     flutter run
     ```

4. **Akses Aplikasi**
   - Backend akan berjalan di server lokal atau sesuai pengaturan server Anda.
   - Frontend dapat diakses melalui perangkat atau emulator yang terhubung.

5. **Testing**
   - Pastikan semua fitur berjalan sesuai dengan yang diharapkan.
   - Lakukan pengujian fungsi login, registrasi, transaksi, dan fitur lainnya.

---
