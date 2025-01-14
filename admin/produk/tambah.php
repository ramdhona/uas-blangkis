<?php
include '../header.php';

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "udinus_ppb_uas";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data kategori
$sql = "SELECT ID, nama_kategori FROM kategori";
$result = $conn->query($sql);
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Produk </h6>
        </div>
        <div class="card-body">
            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="level">Kategori</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="kategori">
                                <option value="">- Pilih Kategori -</option>
                                <?php
                                // Looping data kategori dari database
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['ID'] . '">' . $row['nama_kategori'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Kategori tidak tersedia</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Gambar Produk</label>
                            <input type="file" class="form-control-file" id="gambar_produk" name="gambar_produk">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Deskripsi Produk</label>
                            <textarea class="form-control" id="deskripsi_produk" rows="3" name="deskripsi_produk"></textarea>
                        </div>
                    </div>
                </div>

                <p>
                    <input type="submit" class="btn btn-success" value="Tambah" name="tambah" />
                    <button type="reset" class="btn btn-danger">Reset</button>
                </p>
            </form>
        </div>
    </div>

</div>

<?php
// Menutup koneksi
$conn->close();
include '../footer.php';
?>
