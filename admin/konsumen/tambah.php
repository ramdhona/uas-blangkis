<?php
include '../header.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Konsumen</h6>
        </div>
        <div class="card-body">
            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
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
include '../footer.php';
?>
