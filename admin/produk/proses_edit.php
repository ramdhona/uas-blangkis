<?php
include "../config.php"; // Memastikan koneksi database

// Cek apakah tombol simpan sudah diklik atau belum
if (isset($_POST['simpan'])) {

    // Ambil data dari form edit.php
    $id = $_POST['id'];
    $nama_barang = $_POST['nama_barang']; // Mengganti nama_member dengan nama_barang sesuai dengan tabel produk
    $harga = $_POST['harga'];
    $deskripsi_produk = $_POST['deskripsi_produk'];
    $kategori = $_POST['kategori']; // Untuk kategori
    $gambar_produk = $_FILES['gambar_produk']['name']; // Menangani foto jika ada yang di-upload

    // Validasi jika gambar di-upload
    if (!empty($gambar_produk)) {
        // Ekstensi yang diperbolehkan
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'svg');
        $x = explode('.', $gambar_produk);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['gambar_produk']['size'];
        $file_tmp = $_FILES['gambar_produk']['tmp_name'];

        // Cek ekstensi dan ukuran file
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 1044070) {
                // Pindahkan file ke folder yang sesuai
                move_uploaded_file($file_tmp, '../assets/img/produk/' . $gambar_produk);
            } else {
                echo 'Ukuran file terlalu besar';
                exit;
            }
        } else {
            echo 'Ekstensi file yang di-upload tidak diperbolehkan';
            exit;
        }
    }

    // Query untuk update data produk
    if (!empty($gambar_produk)) {
        // Jika ada gambar baru yang di-upload
        $sql = "UPDATE produk SET nama_barang='$nama_barang', harga='$harga', deskripsi_produk='$deskripsi_produk', kategori_id='$kategori', gambar_produk='$gambar_produk' WHERE id='$id'";
    } else {
        // Jika tidak ada gambar yang di-upload, update tanpa mengganti gambar
        $sql = "UPDATE produk SET nama_barang='$nama_barang', harga='$harga', deskripsi_produk='$deskripsi_produk', kategori_id='$kategori' WHERE id='$id'";
    }

    // Eksekusi query update
    $query = mysqli_query($mysqli, $sql);

    // Cek apakah query update berhasil
    if ($query) {
        // Jika berhasil, alihkan ke halaman produk dengan status berhasil
        header('Location: index.php?aksi=edit&status=berhasil');
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($mysqli);
    }
} else {
    die("Akses Dilarang");
}
