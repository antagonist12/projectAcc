<?php

require '../function/functionadmin.php';

$id = $_GET["id_cust"];


if (hapuscustomer($id) > 0) {
	echo "<script> alert('Data Berhasil Dihapus'); 
	document.location.href = 'customer.php';
	</script>";
} else {
	echo "<script> alert('Data Gagal Dihapus'); 
	document.location.href = 'customer.php';
	</script>";
}
