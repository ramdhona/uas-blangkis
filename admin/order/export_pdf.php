<?php
// Pastikan tidak ada output apapun sebelum TCPDF

require_once __DIR__ . '/../vendor/autoload.php';

// Koneksi ke database
$mysqli = new mysqli("localhost", "rcrafted_blangkis", "blangkisdb", "rcrafted_blangkis");

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Cek apakah parameter periodik ada
if (isset($_GET['periodik'])) {
    // Jika periodik, tampilkan penjualan berdasarkan periode (misalnya bulan)
    $sql = "
        SELECT ph.purchase_id, ph.konsumen_id, ph.tanggal_pembelian, ph.total_harga, ph.ongkir,
               ph.metode_pembayaran,
               GROUP_CONCAT(pd.nama_produk SEPARATOR ', ') AS produk, 
               ph.ekspedisi
        FROM purchase_history ph
        LEFT JOIN purchase_details pd ON ph.purchase_id = pd.purchase_id
        WHERE MONTH(ph.tanggal_pembelian) = MONTH(CURDATE())  -- Menampilkan pembelian bulan ini
        GROUP BY ph.purchase_id
    ";
} else {
    // Jika tidak ada parameter periodik, tampilkan penjualan global
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

// Query untuk mengambil data dari database
$query = mysqli_query($mysqli, $sql);

// Membuat objek TCPDF
$pdf = new TCPDF();

// Mengatur ukuran halaman menjadi landscape
$pdf->AddPage('L');

// Menentukan font lebih kecil
$pdf->SetFont('helvetica', '', 8); // Ukuran font lebih kecil

// Menulis judul PDF
$pdf->Cell(0, 10, 'Riwayat Pembelian - ' . (isset($_GET['periodik']) ? 'Periode' : 'Global'), 0, 1, 'C');

// Mengaktifkan auto page break
$pdf->SetAutoPageBreak(TRUE, 15);

// Menulis header tabel dengan ukuran font kecil
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(25, 10, 'ID', 1, 0, 'C');
$pdf->Cell(25, 10, 'ID User', 1, 0, 'C');
$pdf->Cell(35, 10, 'Tanggal Pembelian', 1, 0, 'C');
$pdf->Cell(25, 10, 'Jenis Bayar', 1, 0, 'C');
$pdf->Cell(25, 10, 'Bank', 1, 0, 'C');
$pdf->Cell(70, 10, 'Produk', 1, 0, 'C'); // Lebar kolom produk lebih sempit
$pdf->Cell(25, 10, 'Total Harga', 1, 0, 'C');
$pdf->Cell(25, 10, 'Biaya Kirim', 1, 0, 'C');
$pdf->Cell(25, 10, 'Total', 1, 0, 'C');
$pdf->Cell(25, 10, 'Ekspedisi', 1, 1, 'C');

// Menulis data pembelian ke tabel
$pdf->SetFont('helvetica', '', 8);

// Looping data dari database
while ($row = mysqli_fetch_array($query)) {
    // Memastikan bahwa produk ada, jika tidak, beri nilai default
    $produk = isset($row['produk']) && !empty($row['produk']) ? $row['produk'] : 'Tidak ada data';

    // Menambahkan data ke dalam tabel PDF
    $pdf->Cell(25, 10, $row['purchase_id'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['konsumen_id'], 1, 0, 'C');
    $pdf->Cell(35, 10, $row['tanggal_pembelian'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['metode_pembayaran'] ?: 'N/A', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Bank ABC', 1, 0, 'C'); // Anda bisa mengganti sesuai data yang ada
    $pdf->Cell(70, 10, $produk, 1, 0, 'L'); // Gunakan Cell untuk produk

    // Menambahkan kolom lainnya
    $pdf->Cell(25, 10, number_format($row['total_harga'], 2), 1, 0, 'C');
    $pdf->Cell(25, 10, number_format($row['ongkir'], 2), 1, 0, 'C');
    $pdf->Cell(25, 10, number_format($row['total_harga'] + $row['ongkir'], 2), 1, 0, 'C');
    $pdf->Cell(25, 10, $row['ekspedisi'], 1, 1, 'C');
}

// Mengoutput file PDF ke browser
$pdf->Output('riwayat_pembelian.pdf', 'I');

?>
