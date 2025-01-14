<?php
include '../header.php';
include '../config.php'; // File konfigurasi database

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validasi jika `id` tidak ada di query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<script>alert("ID produk tidak ditemukan!"); window.location.href="' . $basePath . '";</script>';
    exit;
}

// Ambil id dari query string
$id = mysqli_real_escape_string($mysqli, $_GET['id']);

// Query untuk mengambil data dari database
$sql = "SELECT * FROM produk WHERE id='$id'";
$query = mysqli_query($mysqli, $sql);

// Validasi apakah data ditemukan
if (!$query || mysqli_num_rows($query) < 1) {
    echo '<script>alert("Produk tidak ditemukan!"); window.location.href="' . $basePath . '";</script>';
    exit;
}

// Ambil data produk
$produk = mysqli_fetch_assoc($query);

// Ambil data kategori untuk dropdown
$sql_kategori = "SELECT * FROM kategori";
$query_kategori = mysqli_query($mysqli, $sql_kategori);
$kategori_options = [];
while ($row = mysqli_fetch_assoc($query_kategori)) {
    $kategori_options[] = $row;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Produk</h6>
        </div>
        <div class="card-body">
            <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama_barang">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($produk['nama_barang']); ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($produk['harga']); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori_options as $kategori) : ?>
                                    <option value="<?php echo $kategori['id']; ?>" <?php echo ($produk['kategori_id'] == $kategori['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="deskripsi_produk">Deskripsi Produk</label>
                            <textarea class="form-control" id="deskripsi_produk" rows="3" name="deskripsi_produk" required><?php echo htmlspecialchars($produk['deskripsi_produk']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="gambar_produk">Foto</label><br>
                            <img src="<?php echo $basePath . '/assets/img/produk/' . htmlspecialchars($produk['gambar_produk']); ?>" alt="Gambar Produk" style="width: 50%; margin-bottom: 10px;">
                            <input type="file" class="form-control-file" id="gambar_produk" name="gambar_produk">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($produk['id']); ?>">
                <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                <a href="<?php echo $basePath; ?>" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>

<?php
include '../footer.php';
?>
