<?php

require '../function/functionadmin.php';

$id = $_GET["id_produk"];
$img = $_GET['img'];
$path = "img/produk/" . $img;

if (file_exists("img/produk/$img")) {
    unlink($path);
}

if (hapusproduk($id) > 0) {
    echo "<script> alert('Data Berhasil Dihapus'); 
	document.location.href = 'produk.php';
	</script>";
} else {
    echo "<script> alert('Data Gagal Dihapus'); 
	document.location.href = 'produk.php';
	</script>";
}
