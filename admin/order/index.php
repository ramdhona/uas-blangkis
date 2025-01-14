<?php
include '../header.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Riwayat Pembelian 
                <?php if (isset($_GET['periodik'])) { echo 'Periode'; } else { echo 'Global'; } ?>
            </h6>
        </div>
        <div class="card-body">
            <!-- Form Filter Tanggal -->
            <?php if (isset($_GET['periodik'])): ?>
                <form method="GET" action="" class="mb-4">
                    <input type="hidden" name="periodik" value="true">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="startDate">Tanggal Awal</label>
                            <input type="date" name="startDate" id="startDate" class="form-control" 
                                   value="<?php echo isset($_GET['startDate']) ? $_GET['startDate'] : ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="endDate">Tanggal Akhir</label>
                            <input type="date" name="endDate" id="endDate" class="form-control" 
                                   value="<?php echo isset($_GET['endDate']) ? $_GET['endDate'] : ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Terapkan</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

            <a href="tambah.php" class="btn btn-success mb-3" role="button" aria-pressed="true">Tambah Transaksi</a>
            <a href="export_excel.php" class="btn btn-warning mb-3" role="button" aria-pressed="true">Export Excel</a>
            <a href="export_pdf.php" class="btn btn-danger mb-3" role="button" aria-pressed="true">Export PDF</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="historyTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID User</th>
                            <th>Tanggal Pembelian</th>
                            <th>Jenis Bayar</th>
                            <th>Bank</th>
                            <th>No Rekening</th>
                            <th>Produk</th>
                            <th>Biaya Produk</th>
                            <th>Biaya Kirim</th>
                            <th>Total Harga</th>
                            <th>Ekspedisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>ID User</th>
                            <th>Tanggal Pembelian</th>
                            <th>Jenis Bayar</th>
                            <th>Bank</th>
                            <th>No Rekening</th>
                            <th>Produk</th>
                            <th>Biaya Produk</th>
                            <th>Biaya Kirim</th>
                            <th>Total Harga</th>
                            <th>Ekspedisi</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $startDate = $_GET['startDate'] ?? null;
                        $endDate = $_GET['endDate'] ?? null;

                        if (isset($_GET['periodik'])) {
                            // Filter berdasarkan periode dengan rentang tanggal
                            $sql = "
                                SELECT ph.purchase_id, ph.konsumen_id, ph.tanggal_pembelian, ph.total_harga, ph.ongkir,
                                       ph.metode_pembayaran,
                                       GROUP_CONCAT(pd.nama_produk SEPARATOR ', ') AS produk, 
                                       ph.ekspedisi
                                FROM purchase_history ph
                                LEFT JOIN purchase_details pd ON ph.purchase_id = pd.purchase_id
                                WHERE MONTH(ph.tanggal_pembelian) = MONTH(CURDATE())
                            ";
                            if ($startDate) {
                                $sql .= " AND ph.tanggal_pembelian >= '$startDate'";
                            }
                            if ($endDate) {
                                $sql .= " AND ph.tanggal_pembelian <= '$endDate'";
                            }
                            $sql .= " GROUP BY ph.purchase_id";
                        } else {
                            // Tampilkan data global tanpa filter
                            $sql = "
                                SELECT ph.purchase_id, ph.konsumen_id, ph.tanggal_pembelian, ph.total_harga, ph.ongkir,
                                       ph.metode_pembayaran,
                                       GROUP_CONCAT(pd.nama_produk SEPARATOR ', ') AS produk, 
                                       ph.ekspedisi
                                FROM purchase_history ph
                                LEFT JOIN purchase_details pd ON ph.purchase_id = pd.purchase_id
                                GROUP BY ph.purchase_id
                            ";
                        }

                        $query = mysqli_query($mysqli, $sql);

                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?php echo $row['purchase_id']; ?></td>
                                <td><?php echo $row['konsumen_id']; ?></td>
                                <td><?php echo $row['tanggal_pembelian']; ?></td>
                                <td><?php echo $row['metode_pembayaran'] ?: 'N/A'; ?></td>
                                <td>Bank ABC</td>
                                <td>1234567890</td>
                                <td><?php echo $row['produk'] ?: 'Tidak ada data'; ?></td>
                                <td><?php echo number_format($row['total_harga'], 2); ?></td>
                                <td><?php echo number_format($row['ongkir'], 2); ?></td>
                                <td><?php echo number_format($row['total_harga'] + $row['ongkir'], 2); ?></td>
                                <td><?php echo $row['ekspedisi']; ?></td>
                                <td>
                                <a href="<?php echo $basePath; ?>/order/proses_edit.php?id=<?php echo $row['purchase_id']; ?><?php echo isset($_GET['periodik']) ? '&periodik=true' : ''; ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onClick="hapus(<?php echo $row['purchase_id']; ?>)" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
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
        $("#historyTable").DataTable();
    });

    function hapus(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "hapus.php?id=" + id;
            }
        });
    }
</script>
