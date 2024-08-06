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

// query read semua buku
$buku = queryReadData("SELECT * FROM buku");
//search buku
if (isset($_POST["search"])) {
    $buku = search($_POST["keyword"]);
    }

// Menangani parameter query kategori
if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
    $buku = queryReadData("SELECT * FROM buku WHERE kategori = '$kategori'");
} 

if(isset($_GET["semua"]) ) {
$buku = queryReadData("SELECT * FROM buku");
}
//read buku informatika
if(isset($_POST["pemrograman"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'pemrograman'");
}
//read buku bisnis
if(isset($_POST["novel"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'novel'");
}
//read buku filsafat
if(isset($_POST["komik"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'komik'");
}
//read buku novel
if(isset($_POST["filsafat"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'filsafat'");
}
//read buku sains
if(isset($_POST["hukum"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'hukum'");
}
//read buku sains
if(isset($_POST["biografi"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'biografi'");
}
//read buku sains
if(isset($_POST["dongeng"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'dongeng'");
}
//read buku sains
if(isset($_POST["informatika"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'informatika'");
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Library</title>
    <link rel="stylesheet" href="../style/menu_buku.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
    .detail-container {
        display: none;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color:#012269">
        <div class="container">
            <a class="navbar-brand text-light" href="dashboard_member.php"><span
                    class="text-warning">E-</span>LIBLARI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupporte
                dContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <form class="d-flex flex-nowrap" method="POST" action="">
                    <input class="form-control me-2" type="text" id="keyword" name="keyword" placeholder="Search"
                        aria-label="Search" style="width: 550px;">
                    <button class="btn btn-outline-warning" type="submit" name="search">Search</button>
                </form>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="dropdown">
                    <i class="fa-solid fa-user text-center" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="font-size:20px;background-color:white;color:#333333;border-radius:50%;width:35px;height:35px;cursor:pointer;display: flex; align-items: center; justify-content: center;"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="koleksi_buku.php">Koleksi</a></li>
                        <li><a class="dropdown-item" href="?logout=true">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- List kategori -->
    <div class="container mt-2 py-5">
        <div class="row justify-content-center">
            <div class="col">
                <div class="d-flex gap-2 mt-5 justify-content-center">
                    <form action="" method="post">
                        <div class="layout-card-custom">
                            <?php
                        // Ambil parameter kategori dari URL jika ada
                        $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
                        ?>
                            <?php if (!empty($kategori)) : ?>
                            <a href="menu_buku.php" class="btn btn-outline-primary">Semua</a>
                            <?php else : ?>
                            <button class="btn btn-outline-primary" type="submit" name="kategori"
                                value="semua">Semua</button>
                            <?php endif; ?>
                            <button type="submit" name="informatika"
                                class="btn btn-outline-primary kategori-btn data-kategori">Informatika</button>
                            <button type="submit" name="filsafat"
                                class="btn btn-outline-primary kategori-btn data-kategori">Filsafat</button>
                            <button type="submit" name="novel"
                                class="btn btn-outline-primary kategori-btn data-kategori">Novel</button>
                            <button type="submit" name="pemrograman"
                                class="btn btn-outline-primary kategori-btn data-kategori">Pemrograman</button>
                            <button type="submit" name="komik"
                                class="btn btn-outline-primary kategori-btn data-kategori">Komik</button>
                            <button type="submit" name="hukum"
                                class="btn btn-outline-primary kategori-btn data-kategori">Hukum</button>
                            <button type="submit" name="biografi"
                                class="btn btn-outline-primary kategori-btn data-kategori">Biografi</button>
                            <button type="submit" name="dongeng"
                                class="btn btn-outline-primary kategori-btn data-kategori">Dongeng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Tampilkan Buku dari Database -->
    <div class="container mt-2">
        <div class="row justify-content-center book-container">
            <?php foreach ($buku as $row): ?>
            <div class="col-3 card m-3" style="max-width:250px" data-kategori="<?= $row['kategori'] ?>">
                <img style="max-width: 200px; max-height: 250px;" src="../imgDb/<?= $row['cover'] ?>"
                    class="card-img-top mx-auto" alt="<?= $row['judul'] ?>">
                <div class="card-body">
                    <h5 class="card-title text-center"><?= $row['judul'] ?></h5>
                    <p class="book-details">Penulis : <?= $row['penulis'] ?></p>
                    <p class="book-details">Penerbit : <?= $row['penerbit'] ?></p>
                    <p class="book-details">Tahun terbit : <?= $row['tahun_terbit'] ?></p>
                </div>
                <div class="text-center">
                    <a href="form_pinjam.php?id_buku=<?= $row["id_buku"]; ?>" class="btn btn-primary mx-3 mb-3"
                        style="width:auto;">Pinjam</a>
                    <a href="javascript:void(0);" class="btn btn-primary mx-3 mb-3 detail-btn"
                        data-id="<?= $row['id_buku'] ?>" data-judul="<?= $row['judul'] ?>"
                        data-penulis="<?= $row['penulis'] ?>" data-penerbit="<?= $row['penerbit'] ?>"
                        data-tahun="<?= $row['tahun_terbit'] ?>" data-kategori="<?= $row['kategori'] ?>"
                        data-halaman="<?= $row['jumlah_halaman'] ?>" data-deskripsi="<?= $row['deskripsi_buku'] ?>"
                        style="width:auto;">Detail</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- tampilan detail buku -->
    <div class="container mt-5 detail-container">
        <div class="row justify-content-center">
            <div class="col-8 card">
                <div class="card-body">
                    <h5 class="card-title text-center mb-5" id="detail-judul"></h5>
                    <p class="book-details">Penulis : <span id="detail-penulis"></span></p>
                    <p class="book-details">Penerbit : <span id="detail-penerbit"></span></p>
                    <p class="book-details">Tahun terbit : <span id="detail-tahun"></span></p>
                    <p class="book-details">Kategori : <span id="detail-kategori"></span></p>
                    <p class="book-details">Jumlah Halaman : <span id="detail-halaman"></span></p>
                    <p class="book-details">Deskripsi Buku : <span id="detail-deskripsi"></span></p>
                </div>
                <div class="text-center">
                    <a href="form_pinjam.php?id_buku=<?= $row["id_buku"]; ?>" class="btn btn-primary mx-3 mb-3"
                        style="width:auto;">Pinjam</a>
                    <a href="#book_container" class="btn btn-secondary mx-3 mb-3" id="back-btn"
                        style="width:auto;">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <div class="container-fluid mt-5" style="background-color: #012269">
        <footer class="text-center text-lg-start text-white">
            <div class="container p-4 pb-0">
                <section class="">
                    <div class="row">
                        <div class="col-4 mx-auto mt-3">
                            <h6 class="text-uppercase mb-4 font-weight-bold">
                                E-Liblari
                            </h6>
                            <p>Website Ini di buat untuk memenuhi proyek Akhir Praktikum Pemrograman Web dan juga
                                Pemrograman Web Kelas Reg 5A7</p>
                        </div>
                        <div class="col-4 mx-auto mt-3" style="max-width:max-content;">
                            <h6 class="text-uppercase mb-4 font-weight-bold">Nama Kelompok 7</h6>
                            <p>Dwi Febri Riyanto (220401141)</p>
                            <p>Della Frisca (220401151)</p>
                            <p>Paula Carnelian (220401156)</p>
                            <p>M. Ihsan Auliya (220401160)</p>
                            <p>M. RizkI Ardian (220401152)</p>
                        </div>

                        <div class="col-4 mx-auto mt-3 text-center">
                            <h6 class="text-uppercase mb-4 font-weight-bold">Follow us</h6>

                            <!-- Facebook -->
                            <a class="social-icon m-1" style="background-color: #3b5998;"
                                href="https://www.facebook.com/" role="button">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <!-- Twitter -->
                            <a class="social-icon m-1" style="background-color: #55acee;" href="https://www.twitter.com"
                                role="button">
                                <i class="fab fa-twitter"></i>
                            </a>

                            <!-- Google -->
                            <a class="social-icon m-1" style="background-color: #dd4b39;" href="https://www.google.com"
                                role="button">
                                <i class="fab fa-google"></i>
                            </a>

                            <!-- Instagram -->
                            <a class="social-icon m-1" style="background-color: #ac2bac;"
                                href="https://www.instagram.com" role="button">
                                <i class="fab fa-instagram"></i>
                            </a>

                            <!-- Linkedin -->
                            <a class="social-icon m-1" style="background-color: #0082ca;"
                                href="https://www.linkedin.com" role="button">
                                <i class="fab fa-linkedin-in"></i>
                            </a>

                            <!-- Github -->
                            <a class="social-icon m-1" style="background-color: #333333;" href="https://www.github.com"
                                role="button">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>

                    </div>
                </section>
            </div>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                &copy; 2024 Kelompok 7 Website e-liblari
            </div>
        </footer>
    </div>




    <script src="../javascript/menu_buku.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>