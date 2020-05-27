<?php
require '../function/functionadmin.php';

$id = $_GET["id_retur"];
$update_status_retur = mysqli_query($conn, "UPDATE retur_penjualan SET status = 'Lunas Retur' WHERE id_retur = '$id' ");


if ($update_status_retur == true) {
    echo "<script> alert('Status Retur Berhasil Diubah'); 
    document.location.href = 'laporanRetur.php';
    </script>";
}
