<?php
include '../header.php';

$sql = "SELECT COUNT(*) AS jumlah_produk FROM produk";
$query = mysqli_query($mysqli, $sql);
$jumlah_produk = mysqli_fetch_assoc($query)['jumlah_produk'];

$sql = "SELECT COUNT(*) AS jumlah_konsumen FROM konsumen";
$query = mysqli_query($mysqli, $sql);
$jumlah_konsumen = mysqli_fetch_assoc($query)['jumlah_konsumen'];

$sql = "SELECT COUNT(*) AS jumlah_user FROM user";
$query = mysqli_query($mysqli, $sql);
$jumlah_user = mysqli_fetch_assoc($query)['jumlah_user'];




?>


<!-- Begin Page Content -->
<div class="container-fluid">



    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_produk; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Konsumen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $jumlah_konsumen; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah
                                User
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_user; ?></div>

                        </div>
                        <div class="col-auto">

                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Transaksi</h6>

                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->

    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php
include '../footer.php';
?>