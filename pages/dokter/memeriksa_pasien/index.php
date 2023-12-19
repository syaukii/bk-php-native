<?php
include_once("../../../config/conn.php");
session_start();

if (isset($_SESSION['login'])) {
  $_SESSION['login'] = true;
} else {
  echo "<meta http-equiv='refresh' content='0; url=../auth/login.php'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if ($akses != 'dokter') {
  echo "<meta http-equiv='refresh' content='0; url=..'>";
  die();
}

$pasien = query("SELECT
                  periksa.id AS id_periksa,
                  pasien.id AS id_pasien,
                  periksa.catatan AS catatan,
                  daftar_poli.no_antrian AS no_antrian, 
                  pasien.nama AS nama_pasien, 
                  daftar_poli.keluhan AS keluhan,
                  daftar_poli.status_periksa AS status_periksa
                FROM pasien 
                INNER JOIN daftar_poli ON pasien.id = daftar_poli.id_pasien
                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli");

$periksa = query("SELECT * from periksa");

$obat = query("SELECT * FROM obat");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= getenv('APP_NAME') ?> | Poliklinik</title>

  <?php include "../../../layouts/plugin_header.php" ?>
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
              <!-- <h1 class="m-0">Profil <?= ucwords($_SESSION['akses']) ?></h1> -->
              <h1 class="m-0">Daftar Periksa</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-body p-0">
            <table class="table">
              <thead>
                <tr>
                  <th style="width: 8%">No Urut</th>
                  <th style="width: 40%">Nama Pasien</th>
                  <th style="width: 40%">Keluhan</th>
                  <th style="width: 15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pasien as $pasiens) : ?>
                  <tr>
                    <td id="id" class="text-center"><?= $pasiens["no_antrian"] ?></td>
                    <td><?= $pasiens["nama_pasien"] ?></td>
                    <td><?= $pasiens["keluhan"] ?></td>

                    <td>
                      <?php if ($pasiens["status_periksa"] == 0) { ?>
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPeriksa">Periksa</button> -->
                        <a href="create.php/<?= $pasiens['id_pasien'] ?>" class="btn btn-primary"><i class="fas fa-stethoscope"></i> Periksa </a>
                        <?php } else { ?>
                          <a href="edit.php/<?= $pasiens['id_periksa'] ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit </a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalTambahPeriksa" tabindex="-1" role="dialog" aria-labelledby="modalTambahPeriksaLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPeriksaLabel">Detail Periksa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- Form untuk menambahkan data periksa -->
                <form action="" method="POST">
                  <!-- Kolom input untuk menambahkan data -->
                  <div class="form-group">
                    <label for="nama_pasien">Nama Pasien</label>
                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?= $pasiens["nama_pasien"] ?>" disabled>
                  </div>
                  
                  <div class="form-group">
                    <label for="tgl_periksa">Tanggal Periksa</label>
                    <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" value="<?= $pariksa["tgl_periksa"] ?>">
                  </div>
                  
                  <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <input type="text" class="form-control" id="catatan" name="catatan" value="<?= $pasiens["catatan"] ?>">
                  </div>

                  <div class="form-group">
                    <label for="nama_pasien">Obat</label>
                    <select multiple="" class="form-control">
                      <?php foreach ($obat as $obats) : ?>
                        <option value="<?= $obats['id']; ?>"><?= $obats['nama_obat']; ?> - <?= $obats['kemasan']; ?> - Rp.<?= $obats['harga']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- Tombol untuk mengirim form -->
                  <button type="submit" class="btn btn-primary" id="simpan_periksa" name="simpan_periksa">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php
        if (isset($_POST['simpan_periksa'])) {
          if (isset($_POST['$id'])) {
            try {
              $tgl_periksa = mysqli_real_escape_string($conn, $_POST['tgl_periksa']);
              $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

              $query = "INSERT INTO pasien VALUES ('', '$tgl_periksa', '$catatan')";
              mysqli_query($conn, $query);
            } catch (\Exception $e) {
              var_dump($e->getMessage());
            }
          }
        }
        ?>

      </section>
      <!-- /.content -->
    </div>
    <?php include "../../../layouts/footer.php"; ?>
  </div>
  <?php include "../../../layouts/pluginsexport.php"; ?>
</body>

</html>