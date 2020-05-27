<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


require '../function/functionadmin.php';
require_once __DIR__ . '/vendor/autoload.php';

$idDetail = $_GET['id'];

$id  = $_SESSION["admin"]["id_admin"];

$adminProfil = query("SELECT * FROM admins WHERE id_admin = $id")[0];

$detailpenjualan = query("SELECT * FROM penjualan JOIN customer ON penjualan.id_cust = customer.id_cust WHERE penjualan.id_penjualan='$idDetail' ")[0];

$detailproduk = query("SELECT * FROM detail_penjualan JOIN produk ON detail_penjualan.id_produk = produk.id_produk WHERE detail_penjualan.id_penjualan='$idDetail' ");

if (isset($_POST['cetak'])) {

    $idDetail = $_GET['id'];

    $detailpenjualan = query("SELECT * FROM penjualan JOIN customer ON penjualan.id_cust = customer.id_cust WHERE penjualan.id_penjualan='$idDetail' ")[0];

    $detailproduk = query("SELECT * FROM detail_penjualan JOIN produk ON detail_penjualan.id_produk = produk.id_produk WHERE detail_penjualan.id_penjualan='$idDetail' ");

    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>

    <h1>Laporan Penjualan</h1>

    <div>
    
    <p>Nama Customer : ' . $detailpenjualan['nama'] . '</p>
    <p>No.Telf Customer : ' . $detailpenjualan['no_telp'] . '</p>
    <p>Alamat Customer : ' . $detailpenjualan['alamat'] . '</p>
    <p>Tanggal Penjualan : ' . date('d F Y', strtotime($detailpenjualan['tgl_penjualan'])) . '</p>
    <p>Status Penjualan :' . $detailpenjualan['status'] . '</p>
    </div>


        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah Produk Dibeli</th>
                <th scope="col">Biaya Ongkir</th>
                <th scope="col">Diskon</th>
                <th scope="col">Total Harga Produk</th>
                </tr>';

    $i = 1;
    foreach ($detailproduk as $row) {
        $html .= '<tr>

        <td>' . $i++ . '</td>
        <td>' . $row['nama_produk'] . '</td>
        <td> Rp. ' . number_format($row['harga_jual']) . '</td>
        <td>' . $row['jumbel'] . '</td>
        <td>' . $row['ongkir'] . '</td>
        <td>' . $row['diskon'] . '</td>
        <td> Rp. ' . number_format($row['sub_total']) . '</td>

        </tr>';
    }
    $html .= '
    <tfoot>
        <tr>
            <th colspan="6">Total Penjualan</th>
            <th>Rp.' .  number_format($detailpenjualan['total_penjualan']) . '</th>
    </tr>
    </tfoot>

    ';

    $html .= '</thead>
    </table>

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
                        <h1 class="h3 mb-0 text-gray-800">Detail Penjualan</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">
                            <div class="row">
                                <div class="col-md">
                                    <div class="customer">
                                        <p>Nama Customer : <?= $detailpenjualan['nama']; ?></p>
                                        <p>Tanggal Penjualan : <?= date("d M Y ", strtotime($detailpenjualan['tgl_penjualan'])); ?></p>
                                        <p>No. Telf Customer : <?= $detailpenjualan['no_telp']; ?></p>
                                        <p>Status : <?= $detailpenjualan['status']; ?></p>
                                        <?php if ($detailpenjualan['status'] == 'Penjualan') : ?>
                                            <a href="lunasPenjualan.php?id_penjualan=<?= $detailpenjualan["id_penjualan"]; ?>"" class=" btn btn-success mb-3" onclick="return confirm('Apakah Penjualan Sudah Lunas ?')">Lunas Penjualan</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Jumlah Produk Dibeli</th>
                                        <th scope="col">Biaya Ongkir</th>
                                        <th scope="col">Diskon</th>
                                        <th scope="col">Total Harga Produk</th>
                                    </tr>
                                </thead>
                                <?php $i = 1; ?>
                                <?php foreach ($detailproduk as $row) : ?>
                                    <tbody>
                                        <tr>
                                            <td scope="row"><?= $i; ?></td>
                                            <td><?= $row["nama_produk"]; ?></td>
                                            <td>Rp. <?= number_format($row["harga_jual"]); ?> </td>
                                            <td><?= $row["jumbel"]; ?></td>
                                            <td>Rp. <?= $row["ongkir"]; ?></td>
                                            <td>Rp. <?= $row["diskon"]; ?></td>
                                            <td>Rp. <?= number_format($row["sub_total"]); ?></td>
                                        </tr>
                                    </tbody>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="6">Total Penjualan</th>
                                        <th>Rp. <?= number_format($detailpenjualan['total_penjualan']) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <form action="" method="post" target="_blank">
                                <button type="submit" class="btn btn-primary mb-3" name="cetak">Print Detail Penjualan</button>
                                <a href="laporan.php" class="btn btn-secondary mb-3">Kembali</a>
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