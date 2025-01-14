<?php
// Pastikan Anda sudah menginstal PhpSpreadsheet menggunakan Composer
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Koneksi ke database
$mysqli = new mysqli("localhost", "rcrafted_blangkis", "blangkisdb", "rcrafted_blangkis");

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Cek apakah parameter periodik ada
if (isset($_GET['periodik'])) {
    // Jika periodik, tampilkan data berdasarkan bulan ini
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
    // Jika tidak ada parameter periodik, tampilkan data global
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

// Query untuk mengambil data
$query = mysqli_query($mysqli, $sql);

// Membuat objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom
$sheet->setCellValue('A1', 'ID Pembelian');
$sheet->setCellValue('B1', 'ID User');
$sheet->setCellValue('C1', 'Tanggal Pembelian');
$sheet->setCellValue('D1', 'Jenis Bayar');
$sheet->setCellValue('E1', 'Bank');
$sheet->setCellValue('F1', 'Produk');
$sheet->setCellValue('G1', 'Total Harga');
$sheet->setCellValue('H1', 'Biaya Kirim');
$sheet->setCellValue('I1', 'Total');
$sheet->setCellValue('J1', 'Ekspedisi');

// Menambahkan data ke Excel
$rowNumber = 2; // Mulai dari baris ke-2 untuk data
while ($row = mysqli_fetch_array($query)) {
    $sheet->setCellValue('A' . $rowNumber, $row['purchase_id']);
    $sheet->setCellValue('B' . $rowNumber, $row['konsumen_id']);
    $sheet->setCellValue('C' . $rowNumber, $row['tanggal_pembelian']);
    $sheet->setCellValue('D' . $rowNumber, $row['metode_pembayaran']);
    $sheet->setCellValue('E' . $rowNumber, 'Bank ABC'); // Anda bisa sesuaikan dengan data yang ada
    $sheet->setCellValue('F' . $rowNumber, $row['produk']);
    $sheet->setCellValue('G' . $rowNumber, number_format($row['total_harga'], 2));
    $sheet->setCellValue('H' . $rowNumber, number_format($row['ongkir'], 2));
    $sheet->setCellValue('I' . $rowNumber, number_format($row['total_harga'] + $row['ongkir'], 2));
    $sheet->setCellValue('J' . $rowNumber, $row['ekspedisi']);
    $rowNumber++;
}

// Menulis file Excel ke browser
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="riwayat_pembelian' . (isset($_GET['periodik']) ? '_periodik' : '') . '.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>
