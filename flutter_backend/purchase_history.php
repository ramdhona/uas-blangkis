<?php
// Koneksi ke database
$host = "localhost"; // Sesuaikan dengan host database
$user = "rcrafted_blangkis"; // Username database
$password = "blangkisdb"; // Password database
$database = "rcrafted_blangkis"; // Nama database

$conn = mysqli_connect($host, $user, $password, $database);

// Periksa koneksi
if (!$conn) {
    die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil konsumen_id dari query string jika ada (filter per pengguna)
    $konsumen_id = isset($_GET['konsumen_id']) ? intval($_GET['konsumen_id']) : null;

    // Query utama untuk purchase_history
    $query = "SELECT * FROM purchase_history";
    if ($konsumen_id) {
        $query .= " WHERE konsumen_id = ?";
    }

    $stmt = $conn->prepare($query);
    if ($konsumen_id) {
        $stmt->bind_param("i", $konsumen_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $history = [];
    while ($row = $result->fetch_assoc()) {
        // Ambil data detail pembelian
        $purchase_id = $row['purchase_id'];
        $details_query = "SELECT * FROM purchase_details WHERE purchase_id = ?";
        $details_stmt = $conn->prepare($details_query);
        $details_stmt->bind_param("i", $purchase_id);
        $details_stmt->execute();
        $details_result = $details_stmt->get_result();

        $details = [];
        while ($detail = $details_result->fetch_assoc()) {
            $details[] = $detail;
        }

        // Tambahkan detail ke masing-masing pembelian
        $row['details'] = $details;
        $history[] = $row;

        $details_stmt->close();
    }

    echo json_encode(["success" => true, "data" => $history]);

    $stmt->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (
        isset($data['konsumen_id']) &&
        isset($data['produk_id']) &&
        isset($data['tanggal_pembelian']) &&
        isset($data['jumlah_barang']) &&
        isset($data['total_harga']) &&
        isset($data['alamat_pengiriman']) &&
        isset($data['metode_pembayaran']) &&
        isset($data['ekspedisi']) &&
        isset($data['ongkir'])
    ) {
        $konsumen_id = $data['konsumen_id'];
        $tanggal_pembelian = $data['tanggal_pembelian'];
        $jumlah_barang = $data['jumlah_barang'];
        $total_harga = $data['total_harga'];
        $alamat_pengiriman = $data['alamat_pengiriman'];
        $metode_pembayaran = $data['metode_pembayaran'];
        $ekspedisi = $data['ekspedisi'];
        $ongkir = $data['ongkir'];
        $produk = $data['produk_id'];

        // Siapkan query untuk memasukkan data ke tabel history_purchase
        $stmt_history = $conn->prepare("INSERT INTO purchase_history (konsumen_id, tanggal_pembelian, jumlah_barang, total_harga, alamat_pengiriman, metode_pembayaran, ekspedisi, ongkir) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_history->bind_param("issdsssi", $konsumen_id, $tanggal_pembelian, $jumlah_barang, $total_harga, $alamat_pengiriman, $metode_pembayaran, $ekspedisi, $ongkir);
        
        if ($stmt_history->execute()) {
            $purchase_id = $stmt_history->insert_id; // Dapatkan ID transaksi

            // Siapkan query untuk memasukkan data ke tabel purchase_details
            $stmt_detail = $conn->prepare("INSERT INTO purchase_details (purchase_id, produk_id, nama_produk, jumlah_barang, harga_satuan, image, kategori_id, ekspedisi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_detail->bind_param("iisidsis", $purchase_id, $produk_id, $nama_produk, $jumlah_barang, $harga_satuan, $image, $kategori_id, $ekspedisi);

            // Masukkan data ke tabel purchase_details untuk setiap produk
            foreach ($produk as $item) {
                $produk_id = $item['produk_id'];
                $nama_produk = $item['nama_produk'];
                $jumlah_barang = $item['jumlah_barang'];
                $harga_satuan = $item['harga_satuan'];
                $image = $item['image'];
                $kategori_id = $item['kategori_id'];
                $ekspedisi = $item['ekspedisi'];

                if (!$stmt_detail->execute()) {
                    echo json_encode(["error" => "Failed to insert purchase details"]);
                    exit();
                }
            }

            echo json_encode(["success" => true, "message" => "Data berhasil disimpan"]);
        } else {
            echo json_encode(["error" => "Failed to insert purchase history"]);
        }

        $stmt_history->close();
        $stmt_detail->close();
    } else {
        echo json_encode(["error" => "Missing required fields"]);
    }
}

$conn->close();
?>
