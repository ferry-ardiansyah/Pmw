<?php 
session_start();
// Cek apakah user sudah login
if(!isset($_SESSION["signIn"])) {
header("Location: ../login/login.php");
exit;
}


require "../config/config.php";

// Tangkap id buku dari URL (GET)
    $idBuku = $_GET["id_buku"];
    $buku = queryReadData("SELECT * FROM buku WHERE id_buku = '$idBuku'");

// Menampilkan data member yang sedang login
    $username_member = $_SESSION["member"]["username_member"];
    $member = queryReadData("SELECT * FROM member WHERE username_member = '$username_member'");

//menampilkan admin
    $admin = queryReadData("SELECT * FROM akun_admin");

// Peminjaman 
if(isset($_POST["pinjam"]) ) {
  
    if(pinjamBuku($_POST) > 0) {
      echo "<script>
      alert('Buku berhasil dipinjam');
      window.location.href = 'koleksi_buku.php';
      </script>";
    }else {
      echo "<script>
      alert('Buku gagal dipinjam!');
      </script>";
    }
    
  }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Library</title>
    <link rel="stylesheet" href="../style/form_pinjam.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="dropdown">
                    <i class="fa-solid fa-user text-center" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="font-size:20px;background-color:white;color:#333333;border-radius:50%;width:35px;height:35px;cursor:pointer;display: flex; align-items: center; justify-content: center;"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#koleksi">Koleksi</a></li>
                        <li><a class="dropdown-item" href="#logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="p-4 mt-5">
        <h2 class="mt-5">Form Peminjaman Buku</h2>
        <div class="card container">
            <h5 class="card-header">Data Lengkap Buku</h5>
            <div class="card-body d-flex flex-wrap gap-5 justify-content-center">
                <p class="card-text">
                    <img src="../imgDb/<?= htmlentities($buku[0]['cover']) ?>" width="200px" height="250px"
                        style="border-radius: 5px;">
                </p>
                <form action="" method="post">
                    <?php foreach ($buku as $item) : ?>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Id Buku</span>
                        <input type="text" class="form-control" placeholder="id buku" aria-label="id_buku"
                            aria-describedby="basic-addon1" value="<?= htmlentities($item['id_buku']) ?>" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Kategori</span>
                        <input type="text" class="form-control" placeholder="Kategori" aria-label="kategori"
                            aria-describedby="basic-addon1" value="<?= htmlentities($item['kategori']) ?>" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Judul</span>
                        <input type="text" class="form-control" placeholder="Judul" aria-label="judul"
                            aria-describedby="basic-addon1" value="<?= htmlentities($item['judul']) ?>" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Penulis</span>
                        <input type="text" class="form-control" placeholder="Penulis" aria-label="penulis"
                            aria-describedby="basic-addon1" value="<?= htmlentities($item['penulis']) ?>" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Penerbit</span>
                        <input type="text" class="form-control" placeholder="penerbit" aria-label="penerbit"
                            aria-describedby="basic-addon1" value="<?= htmlentities($item['penerbit']) ?>" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Tahun Terbit</span>
                        <input type="date" class="form-control" placeholder="tahun terbit" aria-label="tahun_terbit"
                            aria-describedby="basic-addon1" value="<?= htmlentities($item['tahun_terbit']) ?>" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Jumlah Halaman</span>
                        <input type="number" class="form-control" placeholder="jumlah halaman"
                            aria-label="jumlah halaman" aria-describedby="<?= htmlentities($item['jumlah_halaman']) ?>"
                            value="350" readonly>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="deskripsi singkat buku" id="floatingTextarea2"
                            style="height: 100px" readonly><?= htmlentities($item['deskripsi_buku']) ?></textarea>
                        <label for="floatingTextarea2">Deskripsi Buku</label>
                    </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
    </div>

    <div class="card mt-4 container">
        <h5 class="card-header">Data Lengkap Member</h5>
        <div class="card-body">
            <form action="" method="post">
                <?php foreach ($member as $item) : ?>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Username</span>
                    <input type="text" class="form-control" placeholder="username" aria-label="username"
                        aria-describedby="basic-addon1" value="<?= htmlentities($item['username_member']) ?>" readonly>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Nama</span>
                    <input type="text" class="form-control" placeholder="nama" aria-label="nama"
                        aria-describedby="basic-addon1" value="<?= htmlentities($item['nama_member']) ?>" readonly>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Jenis Kelamin</span>
                    <input type="text" class="form-control" placeholder="jenis kelamin" aria-label="jenis_kelamin"
                        aria-describedby="basic-addon1" value="<?= htmlentities($item['jenis_kelamin']) ?>" readonly>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Fakultas</span>
                    <input type="text" class="form-control" placeholder="fakultas" aria-label="fakultas"
                        aria-describedby="basic-addon1" value="<?= htmlentities($item['fakultas']) ?>" readonly>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Prodi</span>
                    <input type="text" class="form-control" placeholder="prodi" aria-label="prodi"
                        aria-describedby="basic-addon1" value="<?= htmlentities($item['prodi']) ?>" readonly>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">No Telepon</span>
                    <input type="text" class="form-control" placeholder="no telepon" aria-label="no_telepon"
                        aria-describedby="basic-addon1" value="<?= htmlentities($item['no_telepon']) ?>" readonly>
                </div>
                <?php endforeach; ?>
            </form>
        </div>
    </div>

    <div class="alert alert-danger mt-4" role="alert">Silahkan periksa kembali data diatas, pastikan sudah benar sebelum
        meminjam buku!. jika ada kesalahan data harap hubungi admin</div>

    <div class="card mt-4 container">
        <h5 class="card-header">Form Pinjam Buku</h5>
        <div class="card-body">
            <form action="" method="post">
                <!--Ambil data id buku-->
                <?php foreach ($buku as $item) : ?>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Id Buku</span>
                    <input type="text" name="id_buku" class="form-control" placeholder="id buku" aria-label="id_buku"
                        aria-describedby="basic-addon1" value="<?= $item["id_buku"]; ?>" readonly>
                </div>
                <?php endforeach; ?>
                <!-- Ambil data Username user yang login-->

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Username</span>
                    <input type="text" name="username_member" class="form-control" placeholder="Username"
                        aria-label="username" aria-describedby="basic-addon1"
                        value="<?php echo htmlentities($_SESSION["member"]["username_member"]); ?>" readonly>
                </div>
                <!--Ambil data id admin-->
                <?php foreach ($admin as $item) : ?>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Id Admin</span>
                    <input type="number" class="form-control" name="id_admin" placeholder="id admin"
                        aria-label="id_admin" aria-describedby="basic-addon1" value="<?= $item['id_admin']; ?>"
                        readonly>
                </div>
                <?php endforeach; ?>
                <div class="input-group mb-3 mt-3">
                    <span class="input-group-text" id="basic-addon1">Tanggal pinjam</span>
                    <input type="date" name="tanggal_peminjaman" class="form-control" placeholder="id buku"
                        aria-label="tanggal_peminjaman" aria-describedby="basic-addon1" required>
                </div>

                <a class="btn btn-danger" href="dashboard_member.php"> Batal</a>
                <button type="submit" class="btn btn-success" name="pinjam">Pinjam</button>
            </form>
        </div>
    </div>
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        &copy; 2024 Kelompok 7 Website e-liblari
    </div>
    <!-- Copyright -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-ho+pP7l6Tk5yPojer1dGsLuFgM3U4UUGl5KkGcoz/0FIjI7M67K+glfO4CJp8p9Y" crossorigin="anonymous">
    </script>
</body>

</html>