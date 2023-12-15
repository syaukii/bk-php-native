<?php
session_start();

$muncul = false;
$arah = null;

if (isset($_SESSION['login'])) {
  $muncul = true;
  $arah = $_SESSION['akses'];
}
?>

<?php
$title = 'Poliklinik';
if ($muncul) :
ob_start();
?>
<?php
$content = ob_get_clean();
include './layouts/index.php';
else:
?>
  <a href="http://<?= $_SERVER['HTTP_HOST']?>/bk-poliklinik/pages/auth/login.php">Ke halaman login dokter</a><br>
  <a href="http://<?= $_SERVER['HTTP_HOST']?>/bk-poliklinik/pages/auth/login-pasien.php">Ke halaman login pasien</a><br>
<?php endif; ?>
