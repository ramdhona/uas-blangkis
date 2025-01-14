<?php
include "../config.php";

// Cek apakah tombol simpan sudah diklik
if (isset($_POST['simpan'])) {
    // Ambil data dari form edit
    $id = $_POST['id'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi jika password diubah
    if (!empty($password)) {
        // Jika password baru diinput, maka enkripsi password baru
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Update query dengan password baru
        $sql = "UPDATE konsumen SET nama_lengkap='$nama_lengkap', username='$username', PASSWORD='$password' WHERE ID='$id'";
    } else {
        // Jika password kosong, jangan ubah password
        $sql = "UPDATE konsumen SET nama_lengkap='$nama_lengkap', username='$username' WHERE ID='$id'";
    }

    // Eksekusi query update
    $query = mysqli_query($mysqli, $sql);

    // Apakah query berhasil?
    if ($query) {
        // Jika berhasil, alihkan ke halaman index.php dengan status berhasil
        header('Location: index.php?aksi=edit&status=berhasil');
    } else {
        // Jika gagal, tampilkan error
        echo "Error: " . mysqli_error($mysqli);
    }
} else {
    // Jika tombol simpan tidak diklik, akses ditolak
    die("Akses Dilarang");
}
?>
