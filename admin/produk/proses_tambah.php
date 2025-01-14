<?php
include "../config.php";

//cek tombol tambah sudah diklik ato belum ?
if (isset($_POST['tambah'])) {

    //ambil data dari tambah.php
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori']; // Perbaikan di sini
    $harga = $_POST['harga'];
    $deskripsi_produk = $_POST['deskripsi_produk'];

    $ekstensi_diperbolehkan = array('png', 'jpg', 'svg');
    $gambar_produk = $_FILES['gambar_produk']['name'];
    $x = explode('.', $gambar_produk);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['gambar_produk']['size'];
    $file_tmp = $_FILES['gambar_produk']['tmp_name'];

    if (!empty($gambar_produk) && in_array($ekstensi, $ekstensi_diperbolehkan)) {
        if ($ukuran < 1044070) {
            move_uploaded_file($file_tmp, '../assets/img/produk/' . $gambar_produk);
        } else {
            echo 'UKURAN FILE TERLALU BESAR';
            exit;
        }
    } else {
        echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
        exit;
    }

    //Buat Query untuk menambahkan data
    $sql = "INSERT INTO produk (nama_barang,kategori_id,harga,deskripsi_produk,gambar_produk) 
            VALUES ('$nama_barang','$kategori','$harga','$deskripsi_produk','$gambar_produk')";

$query = mysqli_query($mysqli, $sql);

// Cek apakah Query simpan data berhasil ?
if ($query) {
    //jika berhasil alihkan ke index.php dengan status = sukses
    header('location: index.php?aksi=tambah_data&status=berhasil');
} else {
    // kalo gagal tetap tampilkan ke index.php dengan status = gagal
    // header('Location: index.php?aksi=tambah_data&status=gagal');
    echo  mysqli_error($mysqli);
}
} else {
die("Akses Dilarang");
}
