<?php
include_once("../../../config/conn.php");
session_start();

if (isset($_SESSION['login'])) {
  $_SESSION['login'] = true;
} else {
  echo "<meta http-equiv='refresh' content='0; url=..'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if ($akses != 'dokter') {
  echo "<meta http-equiv='refresh' content='0; url=..'>";
  die();
}

$dokter = query("SELECT * FROM dokter WHERE nama = '$nama'");

// // ambil data di url
// $id = $_GET["id"];
// // query data mahasiswa berdasarkan id
// $dokter = query("SELECT * FROM dokter WHERE id = $id")[0];


// // cek apakah tombol submit sudah ditekan atau belum
// if (isset($_POST["submit"])) {


//   // cek apakah data berhasil di ubah atau tidak
//   if (ubah($_POST) > 0) {
//     echo "
//             <script>
//                 alert('Data berhasil diubah');
//                 document.location.href = 'index.php';
//             </script>
//         ";
//   } else {
//     echo "
//             <script>
//                 alert('Data Gagal diubah');
//                 document.location.href = 'index.php';
//             </script>
//         ";
//   }
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= getenv('APP_NAME') ?> | Profil</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="http://<?= $_SERVER['HTTP_HOST'] ?>/bk-poliklinik/dist/img/Logo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <?php include "../../../layouts/header.php" ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Profile <?= ucwords($_SESSION['akses']) ?></h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container mt-4">
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No Telepon</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dokter as $Docters) : ?>
                <tr>
                  <td><?= $Docters["nama"]; ?></td>
                  <td><?= $Docters["alamat"]; ?></td>
                  <td><?= $Docters["no_hp"]; ?></td>
                  <td>
                    <a href="">ubah</a> |
                    <a href="">hapus</a>
                  </td>
                </tr>
            </tbody>
          <?php endforeach; ?>
          </table>
        </div>

        <!-- <form action="" method="post">
          <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
          <ul>

            <li>
              <label for="nrp">NRP : </label>
              <input type="text" name="nrp" id="nrp" value="<?= $mhs["nrp"]; ?>">
            </li>
            <li>
              <label for="nama">Nama : </label>
              <input type="text" name="nama" id="nama" require value="<?= $mhs["nama"]; ?>">
            </li>
            <li>
              <label for="email">Email : </label>
              <input type="text" name="email" id="email" value="<?= $mhs["email"]; ?>">
            </li>
            <li>
              <label for="jurusan">Jurusan : </label>
              <input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"]; ?>">
            </li>
            <li>
              <label for="gambar">Gambar : </label>
              <input type="text" name="gambar" id="gambar" value="<?= $mhs["gambar"]; ?>">
            </li>
            <li>
              <button type="submit" name="submit">
                Ubah Data!
              </button>
            </li>
          </ul>

        </form> -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include "../../../layouts/footer.php"; ?>
  </div>
  <!-- ./wrapper -->
  <?php include "../../../layouts/pluginsexport.php"; ?>
</body>

</html>