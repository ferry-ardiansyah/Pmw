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
$member = jumlahMember();
$buku = jumlahBuku();
$pinjam = bukuDipinjam();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../style/admin/dashboard_admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                        <a class="nav-link text-light mx-3" href="#home">Home</a>
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

    <!-- Home -->
    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
        <div class="row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <div class="card text-light" style="width: 350px; height:150px; background-color: #007bff;">
                    <div class="card-body">
                        <h5 class="card-title text-center">MEMBER</h5>
                        <div class="d-flex justify-content-between">
                            <h2 class="align-middle"><i class=" fa-solid fa-users" style="font-size:80px;"></i></h2>
                            <h2><?php echo $member; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-light" style="width: 350px; height:150px; background-color: #ef5350;">
                    <div class="card-body">
                        <h5 class="card-title text-center">BUKU</h5>
                        <div class="d-flex justify-content-between">
                            <h2 class="align-middle"><i class="fa-solid fa-book" style="font-size:80px;"></i></h2>
                            <h2><?php echo $buku; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-light" style="width: 350px; height:150px; background-color: #66bb6a;">
                    <div class="card-body">
                        <h5 class="card-title text-center">BUKU DI PINJAM</h5>
                        <div class="d-flex justify-content-between ">
                            <h2 class="align-middle"><i class=" fa-solid fa-book-open-reader"
                                    style="font-size:80px;"></i></h2>
                            <h2><?php echo $pinjam; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3 text-light" style="background-color:#012269">
        &copy; 2024 Kelompok 7 Website E-liblari
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>