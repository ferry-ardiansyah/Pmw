<?php 
require "../config/config.php"; 

$member = $_GET["username_member"];
if(deleteMember($member) > 0) {
    echo "<script>
    alert('Member berhasil dihapus!');
    document.location.href = 'data_member.php';
    </script>";
  }else {
    echo "<script>
    alert('Member gagal dihapus!');
    document.location.href = 'data_member.php';
    </script>";
}
?>