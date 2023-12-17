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
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}
?>
<?php
$title = 'Poliklinik | Riwayat Pasien';
// Breadcrumb section
ob_start(); ?>
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="<?= $base_dokter; ?>">Home</a></li>
  <li class="breadcrumb-item active">Riwayat Pasien</li>
</ol>
<?php
$breadcrumb = ob_get_clean();
ob_flush();

// Title Section
ob_start(); ?>
Riwayat Pasien
<?php
$main_title = ob_get_clean();
ob_flush();

// Content section
ob_start();
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Daftar Riwayat Pasien</h3>
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pasien</th>
          <th>Alamat</th>
          <th>No. KTP</th>
          <th>No. Telepon</th>
          <th>No. RM</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $data = $pdo->query("SELECT * FROM pasien");
        if ($data->rowCount() == 0) {
          echo "<tr><td colspan='7' align='center'>Tidak ada data</td></tr>";
        } else {
          while ($d = $data->fetch()) {
        ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $d['nama']; ?></td>
              <td><?= $d['alamat']; ?></td>
              <td><?= $d['no_ktp']; ?></td>
              <td><?= $d['no_hp']; ?></td>
              <td><?= $d['no_rm']; ?></td>
              <td>
                <button data-toggle="modal" data-target="#exampleModalScrollable" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail Riwayat Periksa
                </button>
              </td>
            </tr>
            <!-- Modal start here -->
            <!-- Pokoknya, PHP dan SQL ribet masuk sini. Aku malas berpikir sendiri-->
            <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Riwayat <?= $d['nama'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    ...
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal ends here -->
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$content = ob_get_clean();
ob_flush();
?>

<?php include '../../../layouts/index.php'; ?>