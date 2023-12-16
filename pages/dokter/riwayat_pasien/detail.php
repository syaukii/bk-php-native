<?php
include_once '../../../config/conn.php';
session_start();

$url = $_SERVER['REQUEST_URI'];
$url = explode("/", $url);
$id = $url[count($url) - 1];

if (isset($_SESSION['login'])) {
    $_SESSION['login'] = true;
} else {
    echo "<meta http-equiv='refresh' content='0; url=../auth/login.php'>";
    die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];
$id_dokter = $_SESSION['id'];

if ($akses != 'dokter') {
    echo "<meta http-equiv='refresh' content='0; url=../..'>";
    die();
}

$data_pasien = query("SELECT * FROM pasien WHERE id = '$id'")[0];
?>

<?php
$title = 'Poliklinik | Detail Riwayat Pasien';
// Breadcrumb section
ob_start();?>
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="<?=$base_dokter;?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?=$base_dokter . '/riwayat_pasien';?>">Riwayat Pasien</a></li>
  <li class="breadcrumb-item active">Detail Riwayat Pasien</li>
</ol>
<?php
$breadcrumb = ob_get_clean();
ob_flush();

// Title Section
ob_start();?>
Detail Riwayat Pasien
<?php
$main_title = ob_get_clean();
ob_flush();

// Content section
ob_start(); ?>
<div class="card">
  <div class="card-header">
      <h3 class="card-title">Daftar Detail Riwayat Pasien : <?= $data_pasien['nama'] ?></h3>
  </div>
  <div class="card-body">
  <table id="detail-table" class="table table-striped table-bordered">
    <thead>
        <tr>
        <th>No</th>
        <th>Tanggal Periksa</th>
        <th>Nama Pasien</th>
        <th>Nama Dokter</th>
        <th>Keluhan</th>
        <th>Catatan</th>
        <th>Obat</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $pasien_id = $id;
        $data = $pdo->query("SELECT 
                                p.nama AS 'nama_pasien',
                                pr.*,
                                d.nama AS 'nama_dokter',
                                dpo.keluhan AS 'keluhan',
                                GROUP_CONCAT(o.nama_obat SEPARATOR ', ') AS 'obat'
                            FROM periksa pr
                            LEFT JOIN daftar_poli dpo ON (pr.id_daftar_poli = dpo.id)
                            LEFT JOIN jadwal_periksa jp ON (dpo.id_jadwal = jp.id)
                            LEFT JOIN dokter d ON (jp.id_dokter = d.id)
                            LEFT JOIN pasien p ON (dpo.id_pasien = p.id)
                            LEFT JOIN detail_periksa dp ON (pr.id = dp.id_periksa)
                            LEFT JOIN obat o ON (dp.id_obat = o.id)
                            WHERE dpo.id_pasien = '$pasien_id'
                            GROUP BY pr.id
                            ORDER BY pr.tgl_periksa DESC;");
        if ($data->rowCount() == 0) {
        echo "<tr><td colspan='7' align='center'>Tidak ada data</td></tr>";
        } else {
        while ($d = $data->fetch()) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['tgl_periksa']; ?></td>
            <td><?= $d['nama_pasien']; ?></td>
            <td><?= $d['nama_dokter']; ?></td>
            <td><?= $d['keluhan']; ?></td>
            <td><?= $d['catatan']; ?></td>
            <td><?= $d['obat']; ?></td>
        </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$content = ob_get_clean();
ob_flush();
?>

<?php include_once '../../../layouts/index.php'; ?>