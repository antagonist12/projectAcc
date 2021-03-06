<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


require '../function/functionadmin.php';


$id  = $_SESSION["admin"]["id_admin"];

$adminProfil = query("SELECT * FROM admins WHERE id_admin = $id")[0];

$datapenjualan = query("SELECT * FROM penjualan JOIN customer ON penjualan.id_cust = customer.id_cust ORDER BY tgl_penjualan ASC");

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Dashboard</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Daftar Laporan Penjualan</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <a href="cetakLaporan.php" class="btn btn-ungu mb-3">Laporan Penjualan Per-Periode</a>

                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Pembeli</th>
                                        <th scope="col">Tanggal penjualan</th>
                                        <th scope="col">Status penjualan</th>
                                        <th scope="col">Total penjualan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <?php $i = 1; ?>
                                <?php foreach ($datapenjualan as $row) : ?>
                                    <tbody>
                                        <tr>
                                            <td scope="row"><?= $i; ?></td>
                                            <td><?= $row["nama"]; ?></td>
                                            <td><?= date("d M Y ", strtotime($row["tgl_penjualan"])); ?></td>
                                            <td><?= $row["status"]; ?></td>
                                            <td>Rp. <?= number_format($row["total_penjualan"]); ?></td>
                                            <td>
                                                <a href="detailLapPenjualan.php?id=<?= $row["id_penjualan"]; ?>" class="badge badge-info">Detail Penjualan</a>
                                                <!-- <?php if ($row["status"] === "Paid" or $row['status'] === "Sending") : ?>
                                                    <a href="detailPembayaran.php?id=<?= $row["id_penjualan"]; ?>" class="badge badge-success">Lihat Pembayaran</a>
                                                <?php endif ?> -->
                                                <!-- <a href="hapusPenjualan.php?idpenjualan=<?= $row["id_penjualan"]; ?>" onclick="return confirm('Yakin Data Ingin Di Hapus?')" class="badge badge-danger">Delete</a> -->
                                            </td>
                                        </tr>
                                    </tbody>

                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </table>
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