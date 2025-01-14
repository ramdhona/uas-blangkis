<?php
include '../header.php';
include '../config.php'; // File konfigurasi database

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validasi jika `id` tidak ada di query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<script>alert("ID konsumen tidak ditemukan!"); window.location.href="' . $basePath . '";</script>';
    exit;
}

// Ambil id dari query string
$id = mysqli_real_escape_string($mysqli, $_GET['id']);

// Query untuk mengambil data dari database
$sql = "SELECT * FROM konsumen WHERE id='$id'";
$query = mysqli_query($mysqli, $sql);

// Validasi apakah data ditemukan
if (!$query || mysqli_num_rows($query) < 1) {
    echo '<script>alert("Konsumen tidak ditemukan!"); window.location.href="' . $basePath . '";</script>';
    exit;
}

// Ambil data konsumen
$konsumen = mysqli_fetch_assoc($query);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Konsumen</h6>
        </div>
        <div class="card-body">
            <form action="proses_edit.php" method="POST">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($konsumen['nama_lengkap']); ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($konsumen['username']); ?>" required>
                        </div>
                    </div>
                  
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($konsumen['password']); ?>" required>
                            <small>Leave empty if you don't want to change the password.</small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($konsumen['id']); ?>">
                <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                <a href="<?php echo $basePath; ?>" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>

<?php
include '../footer.php';
?>
