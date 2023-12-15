<?php
include_once("../../config/conn.php");
session_start();

if (isset($_SESSION['login'])) {
  $_SESSION['login'] = true;
} else {
  echo "<meta http-equiv='refresh' content='0; url=../auth/login.php'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if ($akses != 'admin') {
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}
?>
<?php
$title = 'Poliklinik | Dokter';
ob_start();
?>
<div>
    <span>Ini Dokter</span>
    <a href="#">coba</a>
</div>
<?php
$content = ob_get_clean();
?>

<?php include '../../layouts/index.php'; ?>