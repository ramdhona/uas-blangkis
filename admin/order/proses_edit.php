<?php
include '../header.php';


// Periksa apakah `id` diberikan melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

// Ambil ID dari URL
$purchase_id = $_GET['id'];

// Query untuk mendapatkan data pembelian berdasarkan ID
$sql = "SELECT * FROM purchase_history WHERE purchase_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $purchase_id);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah data ditemukan
if ($result->num_rows == 0) {
    echo "Data tidak ditemukan!";
    exit;
}

$data = $result->fetch_assoc();

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $tanggal_pembelian = $_POST['tanggal_pembelian'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $ekspedisi = $_POST['ekspedisi'];
    $total_harga = $_POST['total_harga'];
    $ongkir = $_POST['ongkir'];

    // Query untuk update data
    $update_sql = "
        UPDATE purchase_history 
        SET 
            tanggal_pembelian = ?, 
            metode_pembayaran = ?, 
            ekspedisi = ?, 
            total_harga = ?, 
            ongkir = ?
        WHERE purchase_id = ?
    ";
    $update_stmt = $mysqli->prepare($update_sql);
    $update_stmt->bind_param(
        "ssssdi",
        $tanggal_pembelian,
        $metode_pembayaran,
        $ekspedisi,
        $total_harga,
        $ongkir,
        $purchase_id
    );

    if ($update_stmt->execute()) {
       echo "<script>
        alert('Data berhasil diupdate!');
        window.location.href = 'index.php" . (isset($_GET['periodik']) && $_GET['periodik'] === 'true' ? "?periodik=true" : "") . "';
      </script>";

    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Riwayat Pembelian</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="tanggal_pembelian">Tanggal Pembelian</label>
            <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" 
                   value="<?php echo $data['tanggal_pembelian']; ?>" required>
        </div>
        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran</label>
            <input type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran" 
                   value="<?php echo $data['metode_pembayaran']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ekspedisi">Ekspedisi</label>
            <input type="text" class="form-control" id="ekspedisi" name="ekspedisi" 
                   value="<?php echo $data['ekspedisi']; ?>" required>
        </div>
        <div class="form-group">
            <label for="total_harga">Total Harga</label>
            <input type="number" step="1" class="form-control" id="total_harga" name="total_harga" 
                   value="<?php echo $data['total_harga']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ongkir">Ongkir</label>
            <input type="number" step="1" class="form-control" id="ongkir" name="ongkir" 
                   value="<?php echo $data['ongkir']; ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php
include '../footer.php';
?>
