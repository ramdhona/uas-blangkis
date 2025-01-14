<?php
include '../header.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">



    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6>
        </div>
        <div class="card-body">
            <a href="<?php echo $basePath; ?>/produk/tambah.php" class="btn btn-success  mb-3" role="button"
                aria-pressed="true">Tambah Produk</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="member" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nama Barang</th>
                            <th>kategori</th>
                            <th>Harga</th>
                            <th>Deskripsi Produk</th>
                            <th>Gambar Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Nama Barang</th>
                            <th>kategori</th>
                            <th>Harga</th>
                            <th>Deskripsi Produk</th>
                            <th>Gambar Produk</th>
                            <th>Aksi</th>

                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                       $sql = "
                       SELECT p.id, p.nama_barang, p.kategori_id, p.harga, p.deskripsi_produk, p.gambar_produk, k.nama_kategori 
                       FROM produk p
                       JOIN kategori k ON p.kategori_id = k.id
                   ";
                   $query = mysqli_query($mysqli, $sql);
                   
                        $nomor = 1;
                        while ($produk = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?php echo $produk['id']; ?></td>
                            <td><?php echo $produk['nama_barang']; ?></td>
                            <td><?php echo $produk['nama_kategori']; ?></td> 
                            <td><?php echo $produk['harga']; ?></td>
                            <td><?php echo $produk['deskripsi_produk']; ?></td>

                            <td> <img style="width: 30% !important;"
                                    src="<?php echo $basePath . '/assets/img/produk/' . $produk['gambar_produk']; ?>" alt="" >
                            </td>


                            <td>
                                <a href="<?php echo $basePath; ?>/produk/edit.php?id=<?php echo $produk['id']; ?>"
                                    class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="#" onClick="hapus(<?php echo $produk['id']; ?>)" class="btn btn-danger"><i
                                        class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include '../footer.php';
?>
<script>
$(document).ready(function() {
    $("#member").DataTable();
});

function hapus(id) {

    Swal.fire({
        title: 'Apkah Anda Yakin?',
        text: "Untuk menghapus data ini",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus aja!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "hapus.php?id=" + id
        }
    })

}

<?php
    if (!empty($_GET['status'])) {

        $pesan = "";
        switch ($_GET['aksi']) {
            case 'tambah_data':
                $pesan = "Tambah data";
                break;
            case 'edit':
                $pesan = "Edit data";
                break;
            case 'hapus':
                $pesan = "hapus data";
                break;
            default:
                # code...
                break;
        }


        if ($_GET['status'] == 'berhasil') {
            echo "Swal.fire(
                    'Success!',
                    '$pesan berhasil dilakukan',
                    'success'
                  )";
        } else {
            echo "tida";
        }
    }
    ?>
</script>