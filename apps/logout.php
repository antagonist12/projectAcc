<?php

session_start();
$_SESSION = [];
session_unset();
session_destroy();
echo "<script>alert('Sampai Jumpa Kembali');</script>";
echo "<script>location='login.php';</script>";
exit;
