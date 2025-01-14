<?php
include '../header.php';

// Jika tidak ada ID di query string
if (!isset($_GET['id'])) {
    echo '<script>window.location.href="' . $basePath . '"</script>';
    return;
}

// Ambil ID dari query string
$id = $_GET['id'];

// Buat query untuk ambil data dari database
$sql = "SELECT * FROM user WHERE id = $id";
$query = mysqli_query($mysqli, $sql);
$user = mysqli_fetch_assoc($query);

// Jika data yang diedit tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    die("Data tidak ditemukan");
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Data User</h6>
        </div>
        <div class="card-body">
            <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $user['nama']; ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $user['password']; ?>" required>
                        </div>
                    </div>
                </div>

                <p>
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <input type="submit" class="btn btn-success" value="Simpan" name="simpan" />
                </p>
            </form>
        </div>
    </div>

</div>

<?php
include '../footer.php';
?>
