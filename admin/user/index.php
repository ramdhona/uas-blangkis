<?php
include '../header.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        </div>
        <div class="card-body">
            <a href="<?php echo $basePath; ?>/user/tambah.php" class="btn btn-success mb-3" role="button" aria-pressed="true">Tambah User</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="user" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM user";
                        $query = mysqli_query($mysqli, $sql);
                        if (!$query) {
                            // Jika query gagal, tampilkan error
                            echo "Error: " . mysqli_error($mysqli);
                        } else {
                            $nomor = 1;
                            while ($user = mysqli_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['nama']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['password']; ?></td>
                                    <td>
                                        <a href="<?php echo $basePath; ?>/user/edit.php?id=<?php echo $user['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="#" onClick="hapus(<?php echo $user['id']; ?>)" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php }
                        }
                        ?>
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
