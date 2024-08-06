<?php 
session_start();
// Cek apakah user sudah login
if(!isset($_SESSION["signIn"])) {
    header("Location: ../login/login.php");
    exit;
}

require "../config/config.php";
$akunMember = $_SESSION["member"]["username_member"];
$dataPinjam = queryReadData("SELECT pinjam_buku.id_peminjaman, pinjam_buku.id_buku, buku.judul, pinjam_buku.username_member, member.nama_member, akun_admin.nama_admin, pinjam_buku.tanggal_peminjaman
FROM pinjam_buku
INNER JOIN buku ON pinjam_buku.id_buku = buku.id_buku
INNER JOIN member ON pinjam_buku.username_member = member.username_member
INNER JOIN akun_admin ON pinjam_buku.id_admin = akun_admin.id_admin
WHERE pinjam_buku.username_member = '$akunMember'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOLEKSI BUKU</title>
    <link rel="stylesheet" href="../style/koleksi_buku.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar navbar-expand-lg fixed-top shadow-sm" style="background-color:#012269">
        <div class="container">
            <a class="navbar-brand text-light" href="dashboard_member.php"><span
                    class="text-warning">E-</span>LIBLARI</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="dashboard_member.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="dashboard_member.php#profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="menu_buku.php">E-Book</a>
                    </li>
                </ul>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="dropdown">
                    <i class="fa-solid fa-user text-center" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="font-size:20px;background-color:white;color:#333333;border-radius:50%;width:35px;height:35px;cursor:pointer;display: flex; align-items: center; justify-content: center;"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#koleksi">Koleksi</a></li>
                        <li><a class="dropdown-item" href="?logout=true">Logout</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- koleksi buku -->
    <div class="p-4 mt-2 text-center">
        <div class="mt-5 alert alert-primary fw-bold text-capitalize" role="alert">- Koleksi Buku Yang Anda Pinjam -
        </div>


        <div class="table-responsive mt-2" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped table-hover">
                <thead class="text-center align-middle">
                    <tr>
                        <th class="bg-primary text-light">Id Peminjaman</th>
                        <th class="bg-primary text-light">Id Buku</th>
                        <th class="bg-primary text-light">Judul Buku</th>
                        <th class="bg-primary text-light">Username</th>
                        <th class="bg-primary text-light">Nama Peminjam</th>
                        <th class="bg-primary text-light">Nama Admin</th>
                        <th class="bg-primary text-light">Tanggal Peminjaman</th>
                        <th class="bg-primary text-light">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($dataPinjam as $item) : ?>
                    <tr class="text-center align-middle">
                        <td><?= $item["id_peminjaman"]; ?></td>
                        <td><?= $item["id_buku"]; ?></td>
                        <td><?= $item["judul"]; ?></td>
                        <td><?= $item["username_member"]; ?></td>
                        <td><?= $item["nama_member"]; ?></td>
                        <td><?= $item["nama_admin"]; ?></td>
                        <td><?= $item["tanggal_peminjaman"]; ?></td>
                        <td>
                            <a class="btn btn-success"
                                href="kembalikan_buku.php?id=<?= $item["id_peminjaman"]; ?>">Kembalikan</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Copyright -->
    <div class="text-center p-3 text-light" style="background-color:#012269">
        &copy; 2024 Kelompok 7 Website E-liblari
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>