<?php 
require "../config/config.php";
$bukuId = $_GET["id_buku"];

if(delete($bukuId) > 0) {
  echo "
  <script>
  alert('Data buku berhasil dihapus');
  document.location.href = 'data_buku.php';
  </script>";
}else {
  echo "
  <script>
  alert('Data buku gagal dihapus');
  document.location.href = 'data_buku.php';
  </script>";
}
?>