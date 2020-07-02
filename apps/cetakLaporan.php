<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require '../function/functionadmin.php';
require_once __DIR__ . '/vendor/autoload.php';

$id  = $_SESSION["admin"]["id_admin"];

$adminProfil = query("SELECT * FROM admins WHERE id_admin = $id")[0];

if (isset($_POST['cetak'])) {

    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];

    $datapenjualan = query("SELECT * FROM penjualan JOIN customer ON penjualan.id_cust = customer.id_cust  WHERE tgl_penjualan BETWEEN '$date1' AND '$date2' ");

    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>

    <h1>Laporan Penjualan Per-periode</h1>

    <p>Dari Tanggal :' . date('d M Y', strtotime($date1)) . '</p>
    <p>Sampai Tanggal :' . date('d M Y', strtotime($date2)) . '</p>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>No. Telf Pembeli</th>
                    <th>Alamat Pembeli</th>
                    <th>Tanggal Penjualan</th>
                    <th>Total Pembelian</th>
                </tr>';
    $i = 1;
    $j = 0;
    foreach ($datapenjualan as $row) {
        $j += $row['total_penjualan'];
        $html .= '<tr>
        <td>' . $i++ . '</td>
        <td>' . $row['nama'] . '</td>
        <td>' . $row['no_telp'] . '</td>
        <td>' . $row['alamat'] . '</td>
        <td>' . date('d M Y ', strtotime($row['tgl_penjualan'])) . '</td>
        <td> Rp.' . number_format($row['total_penjualan']) . '</td>
        </tr>';
    }

    $html .= '</thead>
    <tfoot>
    <tr>
        <th colspan="5">Grand Total Penjualan</th>
        <th>Rp.' .  number_format($j) . '</th>
    </tr>
    </tfoot>
    </table>
    <p>*(Total penjualan sudah termasuk PPN)</p>
    </body>
    </html>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output();
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
                        <div class="col-lg-6 mb-4">

                            <form action="" method="post" target="_blank">
                                <div class="form-group row justify-content-center">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="date1">Dari Tanggal</label>
                                            <input type="date" class="form-control" id="date1" name="date1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="date2">Sampai Tanggal</label>
                                            <input type="date" class="form-control" id="date2" name="date2" required>
                                        </div>
                                        <button type="submit" name="cetak" class="btn btn-primary mb-3">Cetak</button>
                                        <a href="laporan.php" class="btn btn-secondary ml-2 mb-3">Kembali</a>
                                    </div>
                                </div>
                            </form>

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