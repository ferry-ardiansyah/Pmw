<?php 
require "../config/config.php";
$idPengembalian = $_GET["id_kembali"];

if(deleteDataPengembalian($idPengembalian) > 0) {
  echo "
  <script>
  alert('Data berhasil dihapus');
  document.location.href = 'histori_pinjam.php';
  </script>";
}else {
  echo "
  <script>
  alert('Data gagal dihapus');
  document.location.href = 'histori_pinjam.php';
  </script>";
}
?>