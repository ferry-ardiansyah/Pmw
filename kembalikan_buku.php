<?php 
session_start();

// Cek apakah user sudah login
if(!isset($_SESSION["signIn"])) {
    header("Location: ../login/login.php");
    exit;
}

require "../config/config.php";
$idPeminjaman = $_GET["id"];
$query = queryReadData("
    SELECT pinjam_buku.id_peminjaman, pinjam_buku.id_buku, buku.judul, pinjam_buku.username_member, member.nama_member, pinjam_buku.id_admin, pinjam_buku.tanggal_peminjaman
    FROM pinjam_buku
    INNER JOIN buku ON pinjam_buku.id_buku = buku.id_buku
    INNER JOIN member ON pinjam_buku.username_member = member.username_member
    WHERE pinjam_buku.id_peminjaman = $idPeminjaman
");

// Jika tombol submit kembalikan diklik
if(isset($_POST["kembalikan"]) ) {
  
  if(pengembalian($_POST) > 0) {
    echo "<script>
    alert('Terimakasih telah mengembalikan buku!');
    window.location.href = 'koleksi_buku.php';
    </script>";
  } else {
    echo "<script>
    alert('Buku gagal dikembalikan');
    </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="..//style/kembalikan_buku.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Form Pengembalian Buku || Member</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color:#012269">
        <div class="container">
            <a class="navbar-brand text-light" href="dashboard_member.php"><span
                    class="text-warning">E-</span>LIBLARI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="p-4 mt-5">
        <div class="card p-3 mt-5">
            <form action="" method="post" class="text-center">
                <h3>Form Pengembalian buku</h3>
                <?php foreach ($query as $item) : ?>
                <div class="mt-3 d-flex flex-wrap justify-content-center gap-3">
                    <div class="mb-3">
                        <label for="id_peminjaman" class="form-label">Id Peminjaman</label>
                        <input type="number" class="form-control" id="id_peminjaman" name="id_peminjaman"
                            value="<?= $item["id_peminjaman"]; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="id_buku" class="form-label">Id Buku</label>
                        <input type="text" class="form-control" id="id_buku" name="id_buku"
                            value="<?= $item["id_buku"]; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?= $item["judul"]; ?>"
                            readonly>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <div class="mb-3">
                        <label for="username_member" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username_member" name="username_member"
                            value="<?= $item["username_member"]; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama_member" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_member" name="nama_member"
                            value="<?= $item["nama_member"]; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="id_admin" class="form-label">Id Admin</label>
                        <input type="number" class="form-control" id="id_admin" name="id_admin"
                            value="<?= $item["id_admin"]; ?>" readonly>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-4">
                    <div class="mb-3">
                        <label for="tgl_peminjaman" class="form-label">Tanggal Buku Dipinjam</label>
                        <input type="date" class="form-control" id="tgl_peminjaman" name="tanggal_peminjaman"
                            value="<?= $item["tanggal_peminjaman"]; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_pengembalian" class="form-label">Tanggal Pengembalian Buku</label>
                        <input type="date" class="form-control" id="tgl_pengembalian" name="tanggal_kembali">
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="d-flex flex-wrap justify-content-center gap-4">
                </div>
                <a class="btn btn-danger mx-2" href="koleksi_buku.php"> Batal</a>
                <button type="submit" class="btn btn-warning text-light mx-2" name="kembalikan">Kembalikan</button>
            </form>
        </div>
    </div>
    <!-- Copyright -->
    <div class="text-center p-3 text-light fixed-bottom" style="background-color:#012269">
        &copy; 2024 Kelompok 7 Website E-liblari
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+pP7l6Tk5yPojer1dGsLuFgM3U4UUGl5KkGcoz/0FIjI7M67K+glfO4CJp8p9Y" crossorigin="anonymous">
    </script>
</body>

</html>