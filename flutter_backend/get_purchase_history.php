<?php
// Menghubungkan ke database
$servername = "localhost";
$username = "rcrafted_blangkis"; // Ganti dengan username database Anda
$password = "blangkisdb"; // Ganti dengan password database Anda
$dbname = "rcrafted_blangkis"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi ke database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data purchase_history
$sql = "SELECT * FROM purchase_history"; // Tabel yang sesuai dengan struktur Anda
$result = $conn->query($sql);

$response = array();
if ($result->num_rows > 0) {
    // Menampilkan data dalam bentuk array asosiatif
    while($row = $result->fetch_assoc()) {
        // Query untuk mengambil detail pembelian berdasarkan purchase_id
        $purchase_id = $row['purchase_id'];
        $details_sql = "SELECT * FROM purchase_details WHERE purchase_id = $purchase_id";
        $details_result = $conn->query($details_sql);

        $details = array();
        if ($details_result->num_rows > 0) {
            // Menambahkan detail ke array
            while($detail_row = $details_result->fetch_assoc()) {
                $details[] = array(
                    "detail_id" => $detail_row["detail_id"],
                    "produk_id" => $detail_row["produk_id"],
                    "nama_produk" => $detail_row["nama_produk"],
                    "jumlah_barang" => $detail_row["jumlah_barang"],
                    "harga_satuan" => $detail_row["harga_satuan"],
                    "image" => $detail_row["image"], // Sesuaikan dengan nama kolom yang sesuai
                    "kategori_id" => $detail_row["kategori_id"],
                    "ekspedisi" => $detail_row["ekspedisi"]
                );
            }
        }

        // Menambahkan data pembelian dan detailnya ke response
        $response[] = array(
            "purchase_id" => $row["purchase_id"],
            "konsumen_id" => $row["konsumen_id"],
            "tanggal_pembelian" => $row["tanggal_pembelian"],
            "jumlah_barang" => $row["jumlah_barang"],
            "total_harga" => $row["total_harga"],
            "alamat_pengiriman" => $row["alamat_pengiriman"], // Sesuaikan kolom jika perlu
            "metode_pembayaran" => $row["metode_pembayaran"],
            "ekspedisi" => $row["ekspedisi"],
            "ongkir" => $row["ongkir"], // Jika ada ongkir
            "details" => $details // Menambahkan detail ke dalam response
        );
    }

    // Kirim respon JSON
    echo json_encode(array("success" => true, "data" => $response));
} else {
    echo json_encode(array("success" => false, "message" => "No transactions found."));
}

$conn->close();
?>
