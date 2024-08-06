<?php
$host = "127.0.0.1";
$username = "root";
$password = "";
$database_name = "library_uas";
$connection = mysqli_connect($host, $username, $password, $database_name);


// MENAMPILKAN DATA KATEGORI BUKU
function queryReadData($query, $params = []) {
  global $connection;
  $stmt = mysqli_prepare($connection, $query);
  
  if (!empty($params)) {
    // Dynamically bind parameters
    $types = str_repeat('s', count($params)); // Assuming all params are strings
    mysqli_stmt_bind_param($stmt, $types, ...$params);
  }
  
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $items = [];
  
  while ($item = mysqli_fetch_assoc($result)) {
    $items[] = $item;
  }
  
  mysqli_stmt_close($stmt);
  return $items;
}

// Menambahkan data buku 
function tambahBuku($dataBuku) {
  global $connection;
  
  $idBuku = $dataBuku["id_buku"];
  $cover = upload();
  $kategoriBuku = $dataBuku["kategori"];
  $judulBuku = $dataBuku["judul"];
  $penulisBuku = $dataBuku["penulis"];
  $penerbitBuku = $dataBuku["penerbit"];
  $tahunTerbit = $dataBuku["tahun_terbit"];
  $jumlahHalaman = $dataBuku["jumlah_halaman"];
  $deskripsiBuku = $dataBuku["deskripsi_buku"];
  
  if(!$cover) {
    return 0;
  } 
  
  $queryInsertDataBuku = "INSERT INTO buku VALUES('$idBuku','$cover', '$kategoriBuku', '$judulBuku', '$penulisBuku', '$penerbitBuku', '$tahunTerbit', $jumlahHalaman, '$deskripsiBuku')";
  
  mysqli_query($connection, $queryInsertDataBuku);
  return mysqli_affected_rows($connection);
  
}       

// Function upload gambar 
function upload() {
  $namaFile = $_FILES["cover"]["name"];
  $ukuranFile = $_FILES["cover"]["size"];
  $error = $_FILES["cover"]["error"];
  $tmpName = $_FILES["cover"]["tmp_name"];
  
  // cek apakah ada gambar yg diupload
  if($error === 4) {
    echo "<script>
    alert('Silahkan upload cover buku terlebih dahulu!')
    </script>";
    return 0;
  }
  
  // cek kesesuaian format gambar
  $jpg = "jpg";
  $jpeg = "jpeg";
  $png = "png";
  $svg = "svg";
  $bmp = "bmp";
  $psd = "psd";
  $tiff = "tiff";
  $formatGambarValid = [$jpg, $jpeg, $png, $svg, $bmp, $psd, $tiff];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  
  if(!in_array($ekstensiGambar, $formatGambarValid)) {
    echo "<script>
    alert('Format file tidak sesuai');
    </script>";
    return 0;
  }
  
  // batas ukuran file
  if($ukuranFile > 2000000) {
    echo "<script>
    alert('Ukuran file terlalu besar!');
    </script>";
    return 0;
  }
  
   //generate nama file baru, agar nama file tdk ada yg sama
  $namaFileBaru = uniqid();
  $namaFileBaru .= ".";
  $namaFileBaru .= $ekstensiGambar;
  
  move_uploaded_file($tmpName, '../imgDB/' . $namaFileBaru);
  return $namaFileBaru;
} 

// Function to search for books
function search($keyword) {
  global $connection;
  $query = "SELECT * FROM buku WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%' OR penerbit LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
  return queryReadData($query);
  }

function pinjamBuku($dataPinjam) {
  global $connection;
  $id_buku = $dataPinjam["id_buku"];
  $username_member = $dataPinjam["username_member"];
  $id_admin = $dataPinjam["id_admin"];
  $tanggal_peminjaman = $dataPinjam["tanggal_peminjaman"];
  
  $queryPinjamBuku = "INSERT INTO pinjam_buku VALUES (null,'$id_buku', '$username_member', '$id_admin','$tanggal_peminjaman')";
  mysqli_query($connection, $queryPinjamBuku);
  return mysqli_affected_rows($connection);
}

// Pengembalian BUKU
function pengembalian($dataBuku) {
  global $connection;
  
  // Variabel pengembalian
  $idPeminjaman = $dataBuku["id_peminjaman"];
  $idBuku = $dataBuku["id_buku"];
  $username = $dataBuku["username_member"];
  $idAdmin = $dataBuku["id_admin"];
  $tanggal_peminjaman = $dataBuku["tanggal_peminjaman"];
  $bukuKembali = $dataBuku["tanggal_kembali"];
  
  // Menghapus data siswa yang sudah mengembalikan buku
  $hapusDataPeminjam = "DELETE FROM pinjam_buku WHERE id_peminjaman = $idPeminjaman";

  // Memasukkan data kedalam tabel pengembalian
  $queryPengembalian = "INSERT INTO kembali_buku VALUES(null, '$idPeminjaman', '$idBuku', '$username', '$idAdmin','$tanggal_peminjaman', '$bukuKembali')";

  
  mysqli_query($connection, $hapusDataPeminjam);
  mysqli_query($connection, $queryPengembalian);
  return mysqli_affected_rows($connection);
}

// Hapus member yang terdaftar
function deleteMember($username_member) {
  global $connection;
  
  $deleteMember = "DELETE FROM member WHERE username_member = '$username_member'";
  mysqli_query($connection, $deleteMember);
  return mysqli_affected_rows($connection);
}

// Hapus history pengembalian data BUKU
function deleteDataPengembalian($idPengembalian) {
  global $connection;
  
  $deleteDataPengembalianBuku = "DELETE FROM kembali_buku WHERE id_pengembalian = '$idPengembalian'";
  mysqli_query($connection, $deleteDataPengembalianBuku);
  return mysqli_affected_rows($connection);
}

// DELETE DATA Buku
function delete($bukuId) {
  global $connection;
  $queryDeleteBuku = "DELETE FROM buku WHERE id_buku = '$bukuId'
  ";
  mysqli_query($connection, $queryDeleteBuku);
  
  return mysqli_affected_rows($connection);
}

// UPDATE || EDIT DATA BUKU 
function updateBuku($dataBuku) {
  global $connection;

  $gambarLama = htmlspecialchars($dataBuku["coverLama"]);
  $idBuku = htmlspecialchars($dataBuku["id_buku"]);
  $kategoriBuku = $dataBuku["kategori"];
  $judulBuku = htmlspecialchars($dataBuku["judul"]);
  $penulisBuku = htmlspecialchars($dataBuku["penulis"]);
  $penerbitBuku = htmlspecialchars($dataBuku["penerbit"]);
  $tahunTerbit = $dataBuku["tahun_terbit"];
  $jumlahHalaman = $dataBuku["jumlah_halaman"];
  $deskripsiBuku = htmlspecialchars($dataBuku["deskripsi_buku"]);
  
  
  // pengecekan mengganti gambar || tidak
  if($_FILES["cover"]["error"] === 4) {
    $cover = $gambarLama;
  }else {
    $cover = upload();
  }
  // 4 === gagal upload gambar
  // 0 === berhasil upload gambar
  
  $queryUpdate = "UPDATE buku SET 
  cover = '$cover',
  id_buku = '$idBuku',
  kategori = '$kategoriBuku',
  judul = '$judulBuku',
  penulis = '$penulisBuku',
  penerbit = '$penerbitBuku',
  tahun_terbit = '$tahunTerbit',
  jumlah_halaman = $jumlahHalaman,
  deskripsi_buku = '$deskripsiBuku'
  WHERE id_buku = '$idBuku'
  ";
  
  mysqli_query($connection, $queryUpdate);
  return mysqli_affected_rows($connection);
}

// fungsi jumlah member
function jumlahMember() {
  global $connection;
  $query = "SELECT COUNT(*) AS count FROM member";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['count'];
}

// Function to get the count of books
function jumlahBuku() {
  global $connection;
  $query = "SELECT COUNT(*) AS count FROM buku";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['count'];
}

// Function to get the count of borrowed books
function bukuDipinjam() {
  global $connection;
  $query = "SELECT COUNT(*) AS count FROM pinjam_buku";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['count'];
}
?>