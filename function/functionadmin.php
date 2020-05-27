<?php

include 'koneksi.php';


// query
function query($data)
{
    global $conn;

    $result = mysqli_query($conn, $data);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// fungsi upload
function upload()
{

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang di upload
    if ($error === 4) {
        echo "<script>
        alert('Pilih Gambar Terlebih Dahulu');
        </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $eksGambarValid = ['jpg', 'jpeg', 'png'];

    // pemecah string
    $ekstensiGambar = explode('.', $namaFile);

    // pengambilan ektensi dan mengubah huruf menjadi huruf kecil semua
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $eksGambarValid)) {
        echo "<script>
        alert('Yang Anda Upload Bukan Gambar');
        </script>";
        return false;
    }

    // pengecekan ukuran gambar
    if ($ukuranFile > 2000000) {
        echo "<script>
        alert('Ukuran Gambar Terlalu Besar');
        </script>";
        return false;
    }

    // penguploadan gambar
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/produk/' . $namaFileBaru);

    return $namaFileBaru;
}

// Admin Sistem Login
function registeradmin($data)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password1"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $nama = mysqli_real_escape_string($conn, $data["nama"]);
    $img = 'default.png';
    $date = time();
    $role = 'staff';

    // cek email
    $result = mysqli_query($conn, "SELECT email FROM admins WHERE email = '$email'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
		alert('Email Telah Terdaftar')
		</script>";
        return false;
    }

    // cek konfirmasi pass
    if ($password !== $password2) {
        echo "<script>
		alert('Password Tidak Sesuai');
		</script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambah user ke database
    $query = "INSERT INTO admins VALUES ('','$email','$password','$nama','$img','$date','$role')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function loginadmin($data)
{
    global $conn;

    // cek login
    // cek usernamenya dulu
    $email = $data['email'];
    $password = $data['password'];

    $result = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email' ");

    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION['admin'] = $row;
            $_SESSION['namaadmin'] = $row['nama'];
            $_SESSION["login"] = true;
            echo "<script> alert('Selamat Datang Di Menu Penjualan'); </script>";
            echo "<script>location='index.php';</script>";
        } else {
            echo "<script> 
				alert('Username / Password Anda Salah'); 
				</script>";
        }
    } else {
        echo "<script> 
            alert('Username / Password Anda Tidak Ada'); 
            </script>";
    }
}

function forgotpassword($data)
{
    global $conn;


    $email = mysqli_real_escape_string($conn, $data['email']);

    // cek email
    $result = mysqli_query($conn, "SELECT email FROM admins WHERE email = '$email'");

    $token = "qwertyupasdfghjkzxcvbnmQWERTYUPASDFGHJKZXCVBNM123456789";
    $token = str_shuffle($token);
    $token = substr($token, 0, 5);

    $datecreated = time();

    // tambah user ke database
    $query = "INSERT INTO forgotpassword VALUES ('','$email','$token','$datecreated')";

    // autoemail
    $mail = new PHPMailer;
    $mail->Host = 'smtp.gmail.com';
    $mail->IsSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->Username = "birdneststore19@gmail.com";
    $mail->Password = "birdnest2019";
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Port = 587; // or 587	
    $mail->isHTML(true);
    $mail->setFrom('birdneststore19@gmail.com');
    $mail->addAddress($email);
    $mail->Subject = 'Forgot Password Bird Nest Store';
    $body = $mail->Body =
        "
    Password Anda Telah Di Reset, Silahkan Klik Link Berikut Mengganti Password.<br>
	<a href='http://localhost/sarang/admin/resetpassword.php?email=$email&token=$token'>Reset Password</a><br><br>
	Salam Hangat,<br>
    Management Bird Nest Store
    ";

    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function resetpassword()
{
    global $conn;


    $email =  $_GET['email'];
    $token =  $_GET['token'];

    // cek email
    $result = mysqli_query($conn, "SELECT email FROM admins WHERE email = '$email'");


    if (mysqli_num_rows($result) === 1) {

        // Cek token
        $token2 = mysqli_query($conn, "SELECT token FROM forgotpassword WHERE token = '$token'");

        if (mysqli_num_rows($token2) === 1) {

            $_SESSION['reset_email'] = $email;

            $newEmail = $_SESSION['reset_email'];

            $newPassword = mysqli_real_escape_string($conn, $_POST['password']);

            $password = password_hash($newPassword, PASSWORD_DEFAULT);

            $query = "UPDATE admins SET 
                password = '$password'
                WHERE email = '$newEmail'
                ";

            mysqli_query($conn, $query);

            $newEmail = session_unset();

            return mysqli_affected_rows($conn);
        }
    }
}

// Admin Profile + Ganti Password
function updateprofile($data)
{
    global $conn;

    $id = $_SESSION['admin']["id_admin"];
    $email = $_SESSION['admin']["email"];
    $nama = $data["nama"];
    $passwordbaru = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasipasswordbaru = mysqli_real_escape_string($conn, $data["password2"]);
    $foto = $_FILES['gambar']['name'];

    // pengecekan konfirmasi password
    if ($passwordbaru !== $konfirmasipasswordbaru) {
        echo "<script>
		alert('konfirmasi password tidak sesuai');
		</script>";
        return false;
    }

    $passwordbaru = password_hash($passwordbaru, PASSWORD_DEFAULT);

    // pengupload gambar
    if ($foto != '') {
        $foto = uploadprofile();
        if ($foto == '') {
            return false;
        } else {
            $query = "UPDATE admins SET 
        email = '$email',
        nama = '$nama',
        password = '$passwordbaru',
        img = '$foto'
        WHERE id_admin = $id
        ";
        }
    } else {
        $query = "UPDATE admins SET 
    email = '$email',
    nama = '$nama',
    password = '$passwordbaru'
    WHERE id_admin = $id
    ";
    }
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function uploadprofile()
{

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang di upload
    if ($error === 4) {

        return false;
    }

    // cek apakah yang diupload adalah gambar
    $eksGambarValid = ['jpg', 'jpeg', 'png'];

    // pemecah string
    $ekstensiGambar = explode('.', $namaFile);

    // pengambilan ektensi dan mengubah huruf menjadi huruf kecil semua
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $eksGambarValid)) {
        echo "<script>
        alert('Yang Anda Upload Bukan Gambar');
        </script>";
        return false;
    }

    // pengecekan ukuran gambar
    if ($ukuranFile > 2000000) {
        echo "<script>
        alert('Ukuran Gambar Terlalu Besar');
        </script>";
        return false;
    }

    // penguploadan gambar
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/profile/' . $namaFileBaru);

    return $namaFileBaru;
}

// Admin Sistem Produk
function tambahproduk($data)
{
    global $conn;

    // pemberian variabel dan memasukannya ke $data
    $nama = htmlspecialchars($data["nama"]);
    $hargaPokok = htmlspecialchars($data["hargaPokok"]);
    $hargaJual = htmlspecialchars($data["hargaJual"]);
    $stok = $data["stok"];
    $keterangan = $data["keterangan"];

    // pengupload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    //query insert data
    $query = "INSERT INTO produk VALUES ('','$nama','$hargaPokok','$hargaJual','$stok','$keterangan','$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusproduk($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id");

    return mysqli_affected_rows($conn);
}

function editproduk($data)
{
    global $conn;

    // pemberian variabel dan memasukannya ke $data
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $hargaPokok = htmlspecialchars($data["hargaPokok"]);
    $hargaJual = htmlspecialchars($data["hargaJual"]);
    $stok = $data["stok"];
    $keterangan = $data["keterangan"];
    $gambar = $_FILES['gambar']['name'];

    if ($gambar != '') {
        $gambar = upload();
        if ($gambar == '') {
            return false;
        } else {
            //query Update data
            $query = "UPDATE produk SET
            nama_produk = '$nama',
            harga_pokok = '$hargaPokok',
            harga_jual = '$hargaJual',
            stok = '$stok',
            keterangan = '$keterangan',
            gambar = '$gambar'
            WHERE id_produk = $id
            ";
        }
    } else {
        //query Update data
        $query = "UPDATE produk SET
        nama_produk = '$nama',
        harga_pokok = '$hargaPokok',
        harga_jual = '$hargaJual',
        stok = '$stok',
        keterangan = '$keterangan'
        WHERE id_produk = $id
        ";
    }

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Add Customer
function tambahcustomer($data)
{
    global $conn;

    // pemberian variabel dan memasukannya ke $data
    $nama = htmlspecialchars($data["namaCust"]);
    $telp = $data["telp"];
    $alamat = $data["alamat"];

    //query insert data
    $query = "INSERT INTO customer VALUES ('','$nama','$telp','$alamat')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapuscustomer($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM customer WHERE id_cust = $id");

    return mysqli_affected_rows($conn);
}


// add penjualan
function tambahpenjualan($data)
{
    global $conn;

    // pemberian variabel dan memasukannya
    $customer = htmlspecialchars($data['customer']);
    $produk = htmlspecialchars($data["produk"]);
    $tglPenjualan = htmlspecialchars($data["tglPenjualan"]);
    $hargaJual = htmlspecialchars($data["hargaJual"]);
    $qty = htmlspecialchars($data["qty"]);
    $sub_total = htmlspecialchars($data["sub_total"]);
    $diskon = htmlspecialchars($data["diskon"]);
    $ongkir = htmlspecialchars($data["ongkir"]);
    $total = htmlspecialchars($data["total"]);

    $result = query("SELECT * FROM produk where id_produk = '$produk' ")[0];

    if ($qty > $result['stok']) {
        echo "<script> alert('QTY Pembelian Melebihi Stok Silahkan Input Kembali'); </script>";
        echo "<script>location='penjualan.php';</script>";
    } elseif ($qty === "0") {
        echo "<script> alert('QTY Pembelian Tidak Boleh 0'); </script>";
        echo "<script>location='penjualan.php';</script>";
    } else {
        //query insert data
        $conn->query("INSERT INTO penjualan VALUES ('','$customer','$tglPenjualan','$total','Penjualan')");
        $idDetailPenjualan = $conn->insert_id;

        $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$produk' ")[0];
        $idProduk = $produkDetail['id_produk'];
        $namaProduk = $produkDetail['nama_produk'];

        $conn->query("INSERT INTO detail_penjualan VALUES ('','$idDetailPenjualan','$idProduk','$qty' ,'$namaProduk','$hargaJual','$sub_total','$diskon','$ongkir') ");

        // update stok produk
        $conn->query("UPDATE produk SET stok = stok - $qty WHERE id_produk = '$idProduk' ");

        return mysqli_affected_rows($conn);
    }
}


// add retur penjualan
function tambahreturpenjualan($data)
{
    global $conn;

    // pemberian variabel dan memasukannya
    $customer = htmlspecialchars($data['customer']);
    $produk = htmlspecialchars($data["produk"]);
    $tglRetur = htmlspecialchars($data["tglRetur"]);
    $hargaJual = htmlspecialchars($data["hargaJual"]);
    $qty = htmlspecialchars($data["qty"]);
    $total = htmlspecialchars($data["total"]);
    $jenis_retur = htmlspecialchars($data['jenis_retur']);

    $result = query("SELECT * FROM produk where id_produk = '$produk' ")[0];
    if ($qty > $result['stok']) {
        echo "<script> alert('QTY Pembelian Melebihi Stok Silahkan Input Kembali'); </script>";
        echo "<script>location='penjualan.php';</script>";
    } elseif ($qty === "0") {
        echo "<script> alert('QTY Pembelian Tidak Boleh 0'); </script>";
        echo "<script>location='penjualan.php';</script>";
    } else {
        //query insert data
        $conn->query("INSERT INTO retur_penjualan VALUES ('','$customer','$tglRetur','$total','Retur','$jenis_retur')");
        $idDetailRetur = $conn->insert_id;

        $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$produk' ")[0];
        $idProduk = $produkDetail['id_produk'];
        $namaProduk = $produkDetail['nama_produk'];

        $conn->query("INSERT INTO detail_retur VALUES ('','$idDetailRetur','$idProduk','$qty' ,'$namaProduk','$hargaJual','$total') ");

        // update stok produk
        $conn->query("UPDATE produk SET stok = stok - $qty WHERE id_produk = '$idProduk' ");

        return mysqli_affected_rows($conn);
    }
}

// kategori
function tambahkategori($data)
{
    global $conn;

    // pemberian variabel dan memasukannya ke $data
    $nama = htmlspecialchars($data["namakategori"]);

    //query insert data
    $query = "INSERT INTO kategori VALUES ('','$nama')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapuskategori($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM kategori WHERE id_kat = $id");

    return mysqli_affected_rows($conn);
}

function editkategori($data)
{
    global $conn;

    // pemberian variabel dan memasukannya ke $data
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);

    //query Update data
    $query = "UPDATE kategori SET
    kategori = '$nama'
    WHERE id_kat = $id
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// Ongkir
function tambahongkir($data)
{
    global $conn;

    // pemberian variabel dan memasukannya ke $data
    $nama = htmlspecialchars($data["namaongkir"]);
    $biaya = htmlspecialchars($data["biaya"]);

    //query insert data
    $query = "INSERT INTO ongkir VALUES ('','$nama','$biaya')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusongkir($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM ongkir WHERE id_ongkir = $id");

    return mysqli_affected_rows($conn);
}

function editongkir($data)
{
    global $conn;

    // pemberian variabel dan memasukannya ke $data
    $id = $data["id"];
    $nama = htmlspecialchars($data["namaongkir"]);
    $biaya = htmlspecialchars($data["biaya"]);

    //query Update data
    $query = "UPDATE ongkir SET
    nama = '$nama',
    biaya = '$biaya'
    WHERE id_ongkir = $id
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Admin Resi
function prosesresi($data)
{
    global $conn;

    $idDetail = $_GET['id'];
    $resi = $data["resi"];
    $status = $data["status"];

    $query = "UPDATE pembelian SET 
					resi ='$resi', 
					status_pembelian = '$status' 
					WHERE id_pembelian = '$idDetail'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
