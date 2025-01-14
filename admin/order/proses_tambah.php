<?php
include "../config.php";

//cek tombol tambah sudah diklik ato belum ?
if (isset($_POST['tambah'])) {

    //ambil data dari tambah.php
    $idmember = $_POST['idmember'];
    $tgl = $_POST['tgl'];
    $jenisByr = $_POST['jenisByr'];
    $bank = $_POST['bank'];
    $norek = $_POST['norek'];
    $biayaKirim = $_POST['biayaKirim'];
    $pembelian = $_POST['pembelian'];
    $totalByr = $_POST['totalByr'];
    $ekspedisi = $_POST['ekspedisi'];
    $status = $_POST['status'];





    //Buat Query untuk menambahkan data
    $sql = "INSERT INTO `order` (idmember,tgl,jenisByr,bank,norek,biayaKirim,pembelian,totalByr,ekspedisi,status) VALUES ('$idmember','$tgl','$jenisByr','$bank','$norek','$biayaKirim','$pembelian','$totalByr','$ekspedisi','$status')";

    $query = mysqli_query($mysqli, $sql);

    // Cek apakah Query simpan data berhasil ?
    if ($query) {

        $idOrder = mysqli_insert_id($mysqli);
        foreach ($_POST['idProduk'] as $key => $produk) {

            $jumlah = $_POST['jmlProduk'][$key];
            $harga = $_POST['hrgProduk'][$key];

            $sql = "INSERT INTO `order_detail` (idorder,idbarang,jml,hrg) VALUES ('$idOrder','$produk','$jumlah','$harga')";
            $query = mysqli_query($mysqli, $sql);
        }

        if ($query) {
            //jika berhasil alihkan ke index.php dengan status = sukses
            header('location: index.php?aksi=tambah_data&status=berhasil');
        } else {
            echo  mysqli_error($mysqli);
        }
    } else {
        // kalo gagal tetap tampilkan ke index.php dengan status = gagal
        // header('Location: index.php?aksi=tambah_data&status=gagal');
        echo  mysqli_error($mysqli);
    }
} else {
    die("Akses Dilarang");
}
