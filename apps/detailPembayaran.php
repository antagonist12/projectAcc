<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


require '../function/functionadmin.php';

$idDetail = $_GET['id'];

$id  = $_SESSION["admin"]["id_admin"];

$adminProfil = query("SELECT * FROM admins WHERE id_admin = $id")[0];

$detailpembayaran = query("SELECT * FROM pembayaran JOIN pembelian ON pembayaran.id_pembelian=pembelian.id_pembelian WHERE pembayaran.id_pembelian='$idDetail' ")[0];

if (isset($_POST['proses'])) {

    if (prosesresi($_POST) > 0) {
        echo "<script> alert('Resi Berhasil Di Tambah'); </script>";
        echo "<script>location='laporan.php';</script>";
    } else {
        echo mysqli_error($conn);
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- sidebar -->
        <?php include 'page/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'page/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Detail Pembayaran</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">


                            <div class="row">
                                <div class="col-md">
                                    <div class="customer">
                                        <p>Pembayaran Ke - <?= $detailpembayaran['id_pembelian']; ?></p>
                                        <p>Nama Customer : <?= $detailpembayaran['nama_bayar']; ?></p>
                                        <p>Bank : <?= $detailpembayaran['bank']; ?></p>
                                        <p>Tanggal Pembayaran : <?= date("d M Y ", strtotime($detailpembayaran['tanggal_bayar'])); ?></p>
                                        <p>Status Pembayaran : <?= $detailpembayaran['status_pembelian']; ?></p>
                                        <p>Resi Pembelian : <?= $detailpembayaran['resi']; ?></p>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <p>Bukti Pembayaran</p>
                                    <a href="../payment/<?= $detailpembayaran['bukti_bayar']; ?>"><img src="../payment/<?= $detailpembayaran['bukti_bayar']; ?>" alt=""></a>
                                </div>
                            </div>

                            <?php if ($detailpembayaran['status_pembelian'] === "Sending") : ?>
                                <a href="laporan.php" class="btn btn-warning">Kembali</a>
                            <?php else : ?>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <form action="" method="post">

                                            <div class="form-group row">
                                                <label for="resi" class="col-sm-5 col-form-label">Resi Pengiriman</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="resi" name="resi" placeholder="Masukkan Resi">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="status" class="col-sm-5 col-form-label">Status Pengiriman</label>
                                                <div class="col-sm-7">
                                                    <select class="custom-select mr-sm-2" id="status" name="status">
                                                        <option value="" selected>Choose...</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Sending">Sending</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="proses">Proses</button>
                                            <a href="laporan.php" class="btn btn-warning">Kembali</a>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>


                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include 'page/footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>

</body>

</html>