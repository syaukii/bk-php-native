<?php
session_start();
include_once("../../config/conn.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Mendapatkan nilai dari form -- atribut name di input
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $no_ktp = $_POST['no_ktp'];
  $no_hp = $_POST['no_hp'];
  // $password = $_POST['password'];

  // Cek apakah pasien sudah terdaftar berdasarkan nomor KTP
  $query_check_pasien = "SELECT id, nama ,no_rm FROM pasien WHERE no_ktp = '$no_ktp'";
  $result_check_pasien = mysqli_query($conn, $query_check_pasien);

  if (mysqli_num_rows($result_check_pasien) > 0) {
    $row = mysqli_fetch_assoc($result_check_pasien);
    // ini kurang baik, jika menggunakan no_ktp maka anak anak tidak bisa memiliki no_rm lebih baik menggunakan no kk


    // Debug: Print data
    // echo "Data yang diperoleh dari database:<br>";
    // print_r($row['nama']);

    // // Debug: Print input data
    // echo "Data yang dimasukkan dari form:<br>";
    // echo "Nama: $nama<br>";
    // echo "Nomor KTP: $no_ktp<br>";

    if ( $row['nama'] != $nama) {
      // Display an alert if the provided name does not match the stored name
      echo "<script>alert(`Nama pasien tidak sesuai dengan nomor KTP yang terdaftar.`);</script>";
      echo "<meta http-equiv='refresh' content='0; url=register.php'>";
      die();
  }

    $_SESSION['login'] = true;
    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $nama;
    $_SESSION['no_rm'] = $row['no_rm'];
    $_SESSION['akses'] = 'pasien';

    echo "<meta http-equiv='refresh' content='0; url=../pasien'>";
    die();
  }
  
  // dapatkan nilai tahun
  $tahun_bulan = date("Ym");

  // ini adalah jika melihat unik RM dari id pasien.
  $query_last_id = "SELECT MAX(id) as max_id FROM pasien";  // kenapa id ?  karena dia unik dan Auto increment. jika jumlah dipake maka ketika ada 1 pasien didelete akan bertabrakan data nya jika tidak diperbauri no urutnya  
  $result_last_id = mysqli_query($conn, $query_last_id);
  $row_last_id = mysqli_fetch_assoc($result_last_id);
  $last_inserted_id = $row_last_id['max_id'] ? $row_last_id['max_id'] : 0;

  $no_rm = $tahun_bulan . "-" . $last_inserted_id+1;



  // -------------------- KETIKA MAU MENGGUNAKAN PASSWORD -----------------------
  // Hash password sebelum menyimpan ke database (gunakan metode keamanan yang lebih baik di produksi)
  // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  // Query untuk menambahkan data ke tabel pasien
  // $query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm, password) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm', '$hashed_password')";


  // Tentukan format nomor RM
  if ($last_inserted_id + 1 < 10) {
    $no_rm = $tahun_bulan . "-00" . ($last_inserted_id + 1);
  } elseif ($last_inserted_id + 1 < 100) {
    $no_rm = $tahun_bulan . "-0" . ($last_inserted_id + 1);
  } else {
    $no_rm = $tahun_bulan . "-" . ($last_inserted_id + 1);
  }

// Lakukan operasi INSERT
  $query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm')";

  // Eksekusi query
  if (mysqli_query($conn, $query)) {
    // Set session variables
    $_SESSION['login'] = true;  //Menandakan langsung login
    $_SESSION['id'] = mysqli_insert_id($conn); //mengambil id
    $_SESSION['username'] = $nama;
    $_SESSION['no_rm'] = $no_rm;
    $_SESSION['akses'] = 'pasien';

    // Redirect ke halaman dashboard
    echo "<meta http-equiv='refresh' content='0; url=../pasien'>";
    die();
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }


  // Tutup koneksi database
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Poliklinik | Registration Page (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Poli</b>klinik</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new account</p>

      <!-- nama -->
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" required placeholder="Full name" name="nama" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <!-- alamat -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" required placeholder="alamat" name="alamat" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-map-marker"></span>
            </div>
          </div>
        </div>
        <!-- no ktp -->
        <div class="input-group mb-3">
          <input type="number" class="form-control" required placeholder="No ktp" name="no_ktp" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-address-book"></span>
            </div>
          </div>
        </div>
        <!-- no hp -->
        <div class="input-group mb-3">
          <input type="number" class="form-control" required placeholder="NO HP" name="no_hp" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone-square"></span>
            </div>
          </div>
        </div>


        <!-- pass -->
        <!-- <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div> -->
        
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="login.php" class="text-center">I already have an account</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>
