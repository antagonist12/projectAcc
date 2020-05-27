<?php
require '../function/functionadmin.php';

$id = $_GET["id_penjualan"];
$detail_penjualan = query("SELECT * FROM detail_penjualan WHERE id_penjualan = '$id' ")[0];
$idproduk = $detail_penjualan['id_produk'];
$produk = query("SELECT * FROM produk WHERE id_produk = '$idproduk' ")[0];

$stok_detail = $detail_penjualan['jumbel'];
$stok_produk = $produk['stok'];
$stok_akhir = $stok_produk + $stok_detail;

$update_stok = mysqli_query($conn, "UPDATE produk SET stok = $stok_akhir WHERE id_produk = '$idproduk' ");
$deletepenjualan = mysqli_query($conn, "DELETE FROM penjualan WHERE id_penjualan ='$id' ");
$deletedetail = mysqli_query($conn, "DELETE FROM detail_penjualan WHERE id_penjualan ='$id' ");

if ($deletedetail == true) {
    echo "<script> alert('Data Berhasil Dihapus'); 
    document.location.href = 'penjualan.php';
    </script>";
}
