<?php 
session_start();
// Cek apakah user sudah login
if(!isset($_SESSION["signIn"])) {
header("Location: ../login/login.php");
exit;
}

// Proses logout
if(isset($_GET['logout'])) {
session_unset();
session_destroy();
header("Location: ../index.php");
exit;
}
//Halaman pengelolaan pengembalian Buku Perustakaaan
require "../config/config.php";
$dataPeminjam = queryReadData("SELECT kembali_buku.id_pengembalian, kembali_buku.id_buku, buku.judul, buku.kategori, kembali_buku.username_member, member.nama_member, member.fakultas, member.prodi, akun_admin.nama_admin, kembali_buku.tanggal_peminjaman, kembali_buku.tanggal_kembali
FROM kembali_buku
INNER JOIN buku ON kembali_buku.id_buku = buku.id_buku
INNER JOIN member ON kembali_buku.username_member = member.username_member
INNER JOIN akun_admin ON kembali_buku.id_admin = akun_admin.id_admin")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History pinjam|| Admin</title>
    <link rel="stylesheet" href="../style/admin/histori_pinjam.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar navbar-expand-lg navbar-light fixed-top mb-5" style="background-color:#012269">
        <div class="container">
            <a class="navbar-brand text-light" href="#"><span class="text-warning">E- </span>LIBLARI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-light mx-3" href="dashboard_admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mx-3" href="data_member.php">Member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mx-3" href="data_buku.php">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mx-3" href="data_pinjam.php">Pinjaman</a>
                    </li>
                </ul>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="dropdown">
                    <i class="fa-solid fa-user text-center" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="font-size:20px;background-color:white;color:#333333;border-radius:50%;width:35px;height:35px;cursor:pointer;display: flex; align-items: center; justify-content: center;"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="?logout=true">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- History peminjaman -->
    <div class="p-4 mt-2">
        <div class="mt-5">
            <div class="mt-2 alert alert-primary fw-bold text-capitalize text-center" role="alert">- List Histori
                Peminjaman -
            </div>
            <div class="table-responsive mt-3" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-striped table-hover">
                    <thead class="text-center align-middle">
                        <tr>
                            <th class="bg-primary text-light">Id Pengembalian</th>
                            <th class="bg-primary text-light">Id Buku</th>
                            <th class="bg-primary text-light">Judul Buku</th>
                            <th class="bg-primary text-light">Kategori</th>
                            <th class="bg-primary text-light">username</th>
                            <th class="bg-primary text-light">Nama</th>
                            <th class="bg-primary text-light">fakultas</th>
                            <th class="bg-primary text-light">prodi</th>
                            <th class="bg-primary text-light">Nama Admin</th>
                            <th class="bg-primary text-light">Tanggal Peminjaman</th>
                            <th class="bg-primary text-light">Tanggal Pengembalian</th>
                            <th class="bg-primary text-light">Delete</th>
                        </tr>
                    </thead>
                    <?php foreach ($dataPeminjam as $item) : ?>
                    <tr class="text-center align-middle">
                        <td><?= $item["id_pengembalian"]; ?></td>
                        <td><?= $item["id_buku"]; ?></td>
                        <td><?= $item["judul"]; ?></td>
                        <td><?= $item["kategori"]; ?></td>
                        <td><?= $item["username_member"]; ?></td>
                        <td><?= $item["nama_member"]; ?></td>
                        <td><?= $item["fakultas"]; ?></td>
                        <td><?= $item["prodi"]; ?></td>
                        <td><?= $item["nama_admin"]; ?></td>
                        <td><?= $item["tanggal_peminjaman"]; ?></td>
                        <td><?= $item["tanggal_kembali"]; ?></td>
                        <td>
                            <div class="action text-center align-middle">
                                <a href="deletehistori.php?id_kembali=<?= $item["id_pengembalian"]; ?>"
                                    class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ?');"><i
                                        class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>


    <!-- Copyright -->
    <div class="text-center p-3 text-light" style="background-color:#012269">
        &copy; 2024 Kelompok 7 Website E-liblari
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>