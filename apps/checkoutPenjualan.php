<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require '../function/functionadmin.php';

if (empty($_SESSION['keranjang']) or !isset($_SESSION["keranjang"])) {
    echo "<script> alert('Keranjang Kosong , Silahkan Belanja Terlebih Dahulu');</script>";
    echo "<script>location='addPenjualan.php';</script>";
}

$id  = $_SESSION["admin"]["id_admin"];
$id_cust  = $_SESSION["deskripsi"]["customer"];
$tglpenjualan = $_SESSION['deskripsi']['tanggal_penjualan'];

$adminProfil = query("SELECT * FROM admins WHERE id_admin = $id")[0];

$produk = query("SELECT * FROM produk");
$customer = query("SELECT * FROM customer WHERE id_cust = $id_cust")[0];

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
                        <h1 class="h3 mb-0 text-gray-800">Nota Penjualan</h1>
                    </div>

                    <p>Tanggal Penjualan : <?= date('d M Y', strtotime($tglpenjualan)); ?> </p>
                    <p>Nama Customer : <?= $customer['nama']; ?> </p>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <section class="cart">
                            <div class="container">
                                <form method="post">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Jumlah Pembelian</th>
                                                <th>Sub Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $nomor = 1; ?>
                                            <?php $total = 0; ?>
                                            <?php foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) : ?>
                                                <!-- menampilkan produk yang sedang diperulangkan berdasarkan id_produk -->
                                                <?php
                                                $ambil = $conn->query("SELECT * FROM produk
									WHERE id_produk='$id_produk'");
                                                $pecah = $ambil->fetch_assoc();
                                                $subharga = $pecah['harga_jual'] * $jumlah;
                                                ?>
                                                <tr>
                                                    <td><?= $nomor; ?></td>
                                                    <td><?= $pecah['nama_produk']; ?></td>
                                                    <td>Rp. <?= number_format($pecah['harga_jual']); ?></td>
                                                    <td><?= $jumlah; ?></td>
                                                    <td>Rp. <?= number_format($subharga); ?></td>
                                                </tr>
                                                <?php $nomor++; ?>
                                                <?php $total += $subharga; ?>
                                            <?php endforeach ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4">Total Harga Barang</th>
                                                <th>Rp. <?= number_format($total); ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4">PPN</th>
                                                <?php $ppn = $total * (10 / 100); ?>
                                                <th>Rp. <?= number_format($ppn); ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4">Total Penjualan</th>
                                                <?php $totalKeseluruhan = $total + $ppn; ?>
                                                <th>Rp. <?= number_format($totalKeseluruhan); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <button id="checkout" name="checkout" class="btn btn-primary">Selesai Penjualan</button>
                                </form>
                            </div>
                        </section>

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

    <script type="text/javascript">
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>

    <?php
    if (isset($_POST['checkout'])) {

        $id_cust  = $_SESSION["deskripsi"]["customer"];
        $tglpenjualan = $_SESSION['deskripsi']['tanggal_penjualan'];

        // memasukan data pembelian ke tabel pembelian
        $conn->query("INSERT INTO penjualan VALUES ('','$id_cust','$tglpenjualan','$totalKeseluruhan','Penjualan') ");

        // mendapatkan id_pembelian, untuk memasukannya ke tabel detail pembelian
        $id_penjualan_baru = $conn->insert_id;

        foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
            // mandapatkan data produk berdasarkan id produk
            $prdk = query2("SELECT * FROM produk WHERE id_produk = '$id_produk' ");

            $namaprdk = $prdk["nama_produk"];
            $hargaprdk = $prdk["harga_jual"];
            $subhrgprdk = $prdk["harga_jual"] * $jumlah;

            $conn->query("INSERT INTO detail_penjualan VALUES ('','$id_penjualan_baru','$id_produk','$jumlah' ,'$namaprdk','$hargaprdk','$subhrgprdk') ");

            // update stok produk
            $conn->query("UPDATE produk SET stok = stok - $jumlah WHERE id_produk = '$id_produk' ");
        }

        // menghapus keranjang
        unset($_SESSION['keranjang']);

        // tampilan dialihkan ke halaman nota
        echo "<script> alert('Penjualan Berhasil'); </script>";
        echo "<script>location='penjualan.php';</script>";
    }
    ?>

</body>

</html>