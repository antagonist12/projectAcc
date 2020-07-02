<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


require '../function/functionadmin.php';

if (isset($_POST['tambah'])) {

    //mendapatkan jumlah yg diinput
    $id_produk = $_POST['produk'];
    $jumlah = $_POST['qty'];
    $tglPenjualan = $_POST['tglPenjualan'];
    $customer = $_POST['customer'];

    //masuk keranjang belanja
    $_SESSION["keranjang"][$id_produk] = $jumlah;
    $_SESSION["deskripsi"] = [
        'tanggal_penjualan' => $tglPenjualan,
        'customer' => $customer
    ];

    echo "<script>alert('produk telah masuk ke keranjang belanja anda');</script>";
    echo "<script>location='cartPenjualan.php';</script>";

    // if (tambahpenjualan($_POST) > 0) {
    //     echo "<script> alert('Penjualan Berhasil Di Tambah'); </script>";
    //     echo "<script>location='penjualan.php';</script>";
    // } else {
    //     echo mysqli_error($conn);
    // }
}

$id  = $_SESSION["admin"]["id_admin"];

$adminProfil = query("SELECT * FROM admins WHERE id_admin = $id")[0];

$produk = query("SELECT * FROM produk");
$customer = query("SELECT * FROM customer");

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
                        <h1 class="h3 mb-0 text-gray-800">Tambah Penjualan</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->

                        <div class="col-lg-12 mb-4">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tglPenjualan">Tanggal Penjualan</label>
                                            <input type="date" class="form-control" id="tglPenjualan" name="tglPenjualan" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="namacustomer">Nama Customer</label>
                                            <select class="custom-select mr-sm-2" id="customer" name="customer" required>
                                                <option value="" selected>Pilih Customer...</option>
                                                <?php foreach ($customer as $cst) : ?>
                                                    <option value="<?= $cst['id_cust'] ?>">
                                                        <?= $cst['nama'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="namaproduk">Nama Produk</label>
                                            <select class="custom-select mr-sm-2" id="produk" name="produk" required>
                                                <option value="" selected>Pilih Produk...</option>
                                                <?php foreach ($produk as $pr) : ?>
                                                    <option value="<?= $pr['id_produk'] ?>" harga="<?= $pr['harga_jual'] ?>" stok="<?= $pr['stok'] ?>">
                                                        <?= $pr['nama_produk'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="stoktersedia">Stok Tersedia</label>
                                            <input type="number" class="form-control" id="stoktersedia" placeholder="Stok Tersedia" name="stoktersedia" readonly>
                                        </div>

                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="hargaJual">Harga Jual</label>
                                            <input type="number" class="form-control" id="hargaJual" placeholder="Harga" name="hargaJual" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="qty">Quantity</label>
                                            <input type="number" class="form-control" id="qty" placeholder="Quantity" name="qty" required>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="sub_total">Sub Total</label>
                                            <input type="number" class="form-control" id="sub_total" placeholder="Sub Total" name="sub_total" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="diskon">PPN</label>
                                            <input type="text" class="form-control" id="ppn" placeholder="PPN 10%" name="ppn" readonly>
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label for="ongkir">Ongkir</label>
                                            <input type="text" class="form-control" id="ongkir" placeholder="Ongkir" name="ongkir" required>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="total">Total Penjualan</label>
                                            <input type="text" class="form-control" id="total" placeholder="Total Penjualan Barang" name="total" readonly>
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary" name="tambah">Tambah Penjualan</button>
                                <a href="penjualan.php" class="btn btn-warning">Kembali</a>
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
    <script>
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
    <script type="text/javascript">
        $("#produk").change(function() {
            var harga = $("#produk option:selected").attr('harga');
            var stok = $("#produk option:selected").attr('stok');
            $("#hargaJual").val(harga);
            $("#stoktersedia").val(stok);
        });
    </script>
    <script type="text/javascript">
        $("#qty").keyup(function() {
            // var hargajual = document.getElementById('hargaJual').value;
            // var qty = document.getElementById('qty').value;
            // document.getElementById('sub_total').value = total;
            var total = $('#qty').val() * $('#hargaJual').val();
            $("#total").val(total);
            // if (total) {
            //     var hitungPPN = $('#sub_total').val() * parseFloat(10 / 100);
            //     $("#ppn").val(hitungPPN);
            //     var totalAkhir = parseInt($('#sub_total').val()) - parseInt($('#ppn').val());
            //     $('#total').val(totalAkhir);
            // } else {
            //     $("#ppn").val(0);
            //     $('#total').val(0);
            // }
        });

        // $("#ongkir").keyup(function() {
        //     var totalAkhir = parseInt($('#sub_total').val()) - parseInt($('#diskon').val());
        //     var totalPenjualan = (parseInt($('#sub_total').val()) - parseInt($('#diskon').val())) + parseInt($('#ongkir').val());
        //     if (!isNaN(totalPenjualan)) {
        //         $('#total').val(totalPenjualan);
        //     } else {
        //         $('#total').val(totalAkhir);
        //     }
        // });
    </script>
</body>

</html>