<?php
include '../header.php';

$id = $_GET['id'];

$sql = "SELECT *,member.nama_member FROM `order`INNER JOIN member ON member.id = order.idmember  WHERE order.id ='$id' ";
$query = mysqli_query($mysqli, $sql);
$data = mysqli_fetch_assoc($query);

//kalo tidak ada ID di query string
if (!isset($_GET['id'])) {
    echo '<script>window.location.href="' . $basePath . '"</script>';
    return;
}


//buat query untuk ambil data dari database
$sql = "SELECT * FROM `order` WHERE id=$id";
$query = mysqli_query($mysqli, $sql);
$order_detail = mysqli_fetch_assoc($query);

//jika data yang diedit tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    die("data tidak ditemukan");
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">



    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="level">Nama Member</label>
                        <p><?php echo $data['nama_member']; ?></p>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tanggal</label>
                        <p><?php echo $data['tgl']; ?></p>
                    </div>
                </div>


            </div>
            <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Status</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="status">
                                <option>- Pilih Status -</option>
                                <option value="1" <?php if ($order_detail['status'] == "1") {
                                                        echo 'selected';
                                                    } ?>>Selesai
                                </option>
                                <option value="2" <?php if ($order_detail['status'] == "2") {
                                                        echo 'selected';
                                                    } ?>>Proses
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding-top: 32px;">
                        <p>
                            <input type="hidden" name="id" value="<?php echo $order_detail['id']; ?>">
                            <input type="submit" class="btn btn-success" value="Simpan" name="simpan" />
                        </p>
                    </div>
                </div>

            </form>
            <div class="table-responsive">
                <table class="table table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $sql = "SELECT nama,foto,order_detail.jml,order_detail.hrg FROM `order_detail`  INNER JOIN barang ON barang.id = order_detail.idbarang WHERE idorder = '$id'";
                        $query = mysqli_query($mysqli, $sql);
                        $nomor = 1;
                        while ($order_detail = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><img style="width: 100px !important;" src="<?php echo $basePath . '/assets/img/barang/' . $order_detail['foto']; ?>" alt="">
                                    <span class="pl-2"><?php echo $order_detail['nama']; ?></span>
                                </td>
                                <td><?php echo $order_detail['jml']; ?></td>
                                <td><?php echo $order_detail['hrg']; ?></td>
                                <td><?php echo $order_detail['jml'] * $order_detail['hrg']; ?></td>
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
        $("#user").DataTable();
    });

    function hapus(id) {

        Swal.fire({
            title: 'Apkah Anda Yakin?',
            text: "Untuk menghapus data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus aja!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "hapus.php?id=" + id
            }
        })

    }

    <?php
    if (!empty($_GET['status'])) {

        $pesan = "";
        switch ($_GET['aksi']) {
            case 'tambah_data':
                $pesan = "Tambah data";
                break;
            case 'edit':
                $pesan = "Edit data";
                break;
            case 'hapus':
                $pesan = "hapus data";
                break;
            default:
                # code...
                break;
        }


        if ($_GET['status'] == 'berhasil') {
            echo "Swal.fire(
                    'Success!',
                    '$pesan berhasil dilakukan',
                    'success'
                  )";
        } else {
            echo "tida";
        }
    }
    ?>
</script>