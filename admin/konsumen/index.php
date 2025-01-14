<?php
include '../header.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Konsumen</h6>
        </div>
        <div class="card-body">
            <a href="<?php echo $basePath; ?>/konsumen/tambah.php" class="btn btn-success  mb-3" role="button"
                aria-pressed="true">Tambah Konsumen</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="konsumen" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM konsumen";
                        $query = mysqli_query($mysqli, $sql);
                        while ($konsumen = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?php echo $konsumen['id']; ?></td>
                            <td><?php echo $konsumen['nama_lengkap']; ?></td>
                            <td><?php echo $konsumen['username']; ?></td>
                            <td><?php echo $konsumen['password']; ?></td>
                            <td>
                                <a href="<?php echo $basePath; ?>/konsumen/edit.php?id=<?php echo $konsumen['id']; ?>"
                                    class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="#" onClick="hapus(<?php echo $konsumen['id']; ?>)" class="btn btn-danger"><i
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
    $("#konsumen").DataTable();
});

function hapus(id) {

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Untuk menghapus data ini",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus aja!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "hapus.php?id=" + id;
        }
    });
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
