<?php
include "../config.php";

//cek tombol tambah sudah diklik atau belum?
if (isset($_POST['tambah'])) {

    //ambil data dari form tambah
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // enkripsi password

    // Buat query untuk menambahkan data ke tabel konsumen
    $sql = "INSERT INTO konsumen (nama_lengkap, username, password) VALUES ('$nama_lengkap', '$username', '$password')";

    $query = mysqli_query($mysqli, $sql);

    // Cek apakah query simpan data berhasil
    if ($query) {
        // jika berhasil alihkan ke index.php dengan status sukses
        header('Location: index.php?aksi=tambah_data&status=berhasil');
    } else {
        // jika gagal tampilkan error
        echo "Error: " . mysqli_error($mysqli);
    }
} else {
    die("Akses Dilarang");
}
