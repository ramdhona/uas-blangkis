<?php
include "../config.php";

if (isset($_GET['id'])) {

    //ambil id dari query string
    $id = $_GET['id'];

    //buat query hapus
    $sql = "DELETE FROM konsumen WHERE id='$id'";
    // echo $sql;
    // return;

    $query = mysqli_query($mysqli, $sql);

    //apakah query hapus berhasil ato tidak
    if ($query) {
        header('Location: index.php?aksi=hapus&status=berhasil');
    } else {
        header('Location: index.php?aksi=hapus&status=gagal');
    }
} else {
    die("akses dilarang");
}
