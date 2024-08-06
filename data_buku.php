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
require "../config/config.php";

$buku = queryReadData("SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku || Admin</title>
    <link rel="stylesheet" href="../style/admin/data_buku.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Kelola peminjaman buku || admin</title>
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

    <!-- List Buku -->
    <div class="p-4 mt-5">

        <div class="mt-2 alert alert-primary fw-bold text-capitalize text-center" role="alert">- List Data Buku -
        </div>
        <div class="table-responsive mt-3" style="max-height: 400px; overflow-y: auto;">
            <a class="btn btn-warning text-light mb-3 mt-3" href="tambah_buku.php"
                style="font-size:20px;font-weight:500;">Tambah
                Buku</a>
            <table class="table table-striped table-hover table-bordered">
                <thead class="text-center align-middle">
                    <tr>
                        <th class="bg-primary text-light">id</th>
                        <th class="bg-primary text-light">Judul</th>
                        <th class="bg-primary text-light">kategori</th>
                        <th class="bg-primary text-light">Penulis</th>
                        <th class="bg-primary text-light">Penerbit</th>
                        <th class="bg-primary text-light">Tahun Terbit</th>
                        <th class="bg-primary text-light">Jumlah Halaman</th>
                        <th class="bg-primary text-light">Action</th>
                    </tr>
                </thead>
                <?php foreach($buku as $item) : ?>
                <tr class="text-center align-middle">
                    <td><?=$item["id_buku"];?></td>
                    <td><?=$item["judul"];?></td>
                    <td><?=$item["kategori"];?></td>
                    <td><?=$item["penulis"];?></td>
                    <td><?=$item["penerbit"];?></td>
                    <td><?=$item["tahun_terbit"];?></td>
                    <td><?=$item["jumlah_halaman"];?></td>


                    <td class="d-flex justify-content-center gap-3" style="font-size: 20px; padding: 10px;">
                        <a href="editbuku.php?id_buku=<?= $item["id_buku"]; ?>" id="buku" style="padding: 5px;">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 1.5em;"></i>
                        </a>
                        <a href="delete.php?id_buku=<?= $item["id_buku"]; ?>"
                            onclick="return confirm('Yakin ingin menghapus data buku ? ');" style="padding: 5px;">
                            <i class="fa-solid fa-trash" style="font-size: 1.5em;"></i>
                        </a>
                    </td>

                </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
    <!-- Copyright -->
    <div class="text-center p-3 text-light" style="background-color:#012269">
        &copy; 2024 Kelompok 7 Website E-liblari
    </div>
</body>

</html>