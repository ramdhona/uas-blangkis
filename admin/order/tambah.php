<?php
ob_start();
include '../header.php';

// Proses tambah data jika form telah dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $konsumen_id = $_POST['konsumen_id'];
    $tanggal_pembelian = $_POST['tanggal_pembelian'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $produk_id = $_POST['produk'];  // Array produk_id
    $jumlah = $_POST['jumlah'];  // Array jumlah produk
    $total_harga = $_POST['total_harga'];
    $ongkir = $_POST['ongkir'];
    $ekspedisi = $_POST['ekspedisi'];

    // Menyimpan transaksi utama ke purchase_history
    $sql_history = "INSERT INTO `purchase_history` (konsumen_id, tanggal_pembelian, metode_pembayaran, total_harga, ongkir, ekspedisi) 
                    VALUES ('$konsumen_id', '$tanggal_pembelian', '$metode_pembayaran', '$total_harga', '$ongkir', '$ekspedisi')";

    if (mysqli_query($mysqli, $sql_history)) {
        // Ambil purchase_id yang baru disimpan
        $purchase_id = mysqli_insert_id($mysqli);

        // Menyimpan produk dalam purchase_details
        foreach ($produk as $key => $prod_id) {
            $jumlah_produk = $jumlah[$key];

            // Menyimpan produk ke purchase_details dengan produk_id
            $sql_detail = "INSERT INTO `purchase_details` (purchase_id, produk_id, jumlah_barang) 
                           VALUES ('$purchase_id', '$produk_id', '$jumlah_produk')";

            if (!mysqli_query($mysqli, $sql_detail)) {
                echo "Error inserting into purchase_details: " . mysqli_error($mysqli);
                exit();
            }
        }

        // Redirect ke halaman dengan status berhasil
        header("Location: index.php?status=berhasil&aksi=tambah_data");
    } else {
        echo "Error inserting into purchase_history: " . mysqli_error($mysqli);
    }
}

ob_end_flush();
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Transaksi</h6>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="konsumen_id">Id Konsumen</label>
                    <input type="text" class="form-control" id="konsumen_id" name="konsumen_id" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_pembelian">Tanggal Pembelian</label>
                    <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" required>
                </div>
                <div class="form-group">
                    <label for="metode_pembayaran">Metode Pembayaran</label>
                    <input type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                </div>
                <div class="form-group">
                    <label for="produk">Produk</label>
                    <div id="produk-container">
                        <div class="produk-entry">
                            <input type="text" class="form-control" name="produk" placeholder="ID Produk" required>
                            <input type="number" class="form-control" name="jumlah" placeholder="Jumlah Produk" required>
                        </div>
                    </div>
                    <button type="button" onclick="addProduct()">Tambah Produk</button>
                </div>
                <div class="form-group">
                    <label for="total_harga">Total Harga</label>
                    <input type="number" class="form-control" id="total_harga" name="total_harga" required>
                </div>
                <div class="form-group">
                    <label for="ongkir">Ongkir</label>
                    <input type="number" class="form-control" id="ongkir" name="ongkir" required>
                </div>
                <div class="form-group">
                    <label for="ekspedisi">Ekspedisi</label>
                    <input type="text" class="form-control" id="ekspedisi" name="ekspedisi" required>
                </div>
               
                <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php
include '../footer.php';
?>

<script>
    function addProduct() {
        var container = document.getElementById("produk-container");
        var entry = document.createElement("div");
        entry.classList.add("produk-entry");
        entry.innerHTML = `
            <input type="text" class="form-control" name="produk[]" placeholder="ID Produk" required>
            <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah Produk" required>
        `;
        container.appendChild(entry);
    }
</script>
