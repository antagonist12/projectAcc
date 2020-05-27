<?php
require '../function/functionadmin.php';

$id = $_GET["id_retur"];
$retur_penjualan = query("SELECT * FROM detail_retur WHERE id_retur = '$id' ")[0];
$idproduk = $retur_penjualan['id_produk'];
$produk = query("SELECT * FROM produk WHERE id_produk = '$idproduk' ")[0];

$stok_retur = $retur_penjualan['jumbel'];
$stok_produk = $produk['stok'];
$stok_akhir = $stok_produk + $stok_retur;

$update_stok = mysqli_query($conn, "UPDATE produk SET stok = $stok_akhir WHERE id_produk = '$idproduk' ");
$deleteretur = mysqli_query($conn, "DELETE FROM retur_penjualan WHERE id_retur ='$id' ");
$deletereturdetail = mysqli_query($conn, "DELETE FROM detail_retur WHERE id_retur ='$id' ");

if ($deletereturdetail == true) {
    echo "<script> alert('Data Berhasil Dihapus'); 
    document.location.href = 'returPenjualan.php';
    </script>";
}
