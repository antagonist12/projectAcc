<?php
require '../function/functionadmin.php';

$id = $_GET["id_penjualan"];
$update_status_penjualan = mysqli_query($conn, "UPDATE penjualan SET status = 'Lunas' WHERE id_penjualan = '$id' ");


if ($update_status_penjualan == true) {
    echo "<script> alert('Status Penjualan Berhasil Diubah'); 
    document.location.href = 'laporan.php';
    </script>";
}
