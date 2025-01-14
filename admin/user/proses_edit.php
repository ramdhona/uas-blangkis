<?php
include "../config.php";

// Cek apakah tombol simpan sudah diklik atau belum
if (isset($_POST['simpan'])) {

    // Ambil data dari form edit
    $id = $_POST['id'];
    $nama = $_POST['nama'];  // Nama Lengkap
    $username = $_POST['username'];  // Username
    $password = $_POST['password'];  // Password

    // Cek apakah password baru diinputkan
    if (!empty($password)) {
        // Enkripsi password baru jika diubah
        $password = password_hash($password, PASSWORD_BCRYPT);
    } else {
        // Jika password tidak diubah, biarkan password tetap
        // Anda harus menyimpan password lama di dalam hidden field form (current_password)
        $password = $_POST['current_password'];
    }

    // Query update tanpa foto
    $sql = "UPDATE user SET nama='$nama', username='$username', password='$password' WHERE id=$id";

    // Eksekusi query untuk update data
    $query = mysqli_query($mysqli, $sql);

    // Cek apakah query berhasil
    if ($query) {
        // Jika berhasil, alihkan ke halaman index.php dengan status berhasil
        header('Location: index.php?aksi=edit&status=berhasil');
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($mysqli);
    }
} else {
    die("Akses Dilarang");
}
?>
