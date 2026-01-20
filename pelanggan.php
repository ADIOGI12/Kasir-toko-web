<?php
include "confing.php";
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

// Tambah Pelanggan
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $telepon = $_POST['telepon'];

  $sql = "INSERT INTO pelanggan (NamaPelanggan,Alamat,NomorTelepon) 
            VALUES ('$nama','$alamat','$telepon')";
  $query = mysqli_query($koneksi, $sql);
}

// Hapus Pelanggan
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM pelanggan WHERE PelangganID='$id'");
}

// Ambil semua pelanggan
$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Data Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #111 40%, #c70000 100%);
      min-height: 100vh;
      font-family: "Poppins", sans-serif;
      color: white;
    }

    .navbar {
      background-color: #111 !important;
      border-bottom: 3px solid #c70000;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.5rem;
      color: #fff !important;
      text-shadow: 2px 2px #c70000;
    }

    .nav-link {
      color: #fff !important;
      font-weight: 500;
      transition: 0.3s;
    }

    .nav-link:hover {
      color: #c70000 !important;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
      transition: transform 0.2s;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card-header {
      font-weight: bold;
      background-color: #c70000 !important;
      color: #fff;
    }

    table th,
    table td {
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="dashboard.php">🎭 PersonaKasir</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">🏠 Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="produk.php">📦 Produk</a></li>
          <li class="nav-item"><a class="nav-link active text-danger fw-bold" href="pelanggan.php">👥 Pelanggan</a></li>
          <li class="nav-item"><a class="nav-link" href="transaksi.php">🛒 Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="laporan.php">📑 Laporan</a></li>
          <li class="nav-item"><a class="nav-link text-danger fw-bold" href="logout.php">🚪 Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten -->
  <div class="container py-4">
    <h2 class="mb-4">👥 Data Pelanggan</h2>

    <!-- Form Tambah -->
    <div class="card mb-4">
      <div class="card-header">Tambah Pelanggan</div>
      <div class="card-body">
        <form method="post" class="row g-3">
          <div class="col-md-4">
            <input type="text" name="nama" class="form-control" placeholder="Nama Pelanggan" required>
          </div>
          <div class="col-md-4">
            <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
          </div>
          <div class="col-md-3">
            <input type="text" name="telepon" class="form-control" placeholder="Nomor Telepon" required>
          </div>
          <div class="col-md-1">
            <button type="submit" name="tambah" class="btn btn-dark w-100">Tambah</button>
          </div>
        </form>
      </div>
    </div>

    <!-- List Pelanggan -->
    <div class="card">
      <div class="card-header">Daftar Pelanggan</div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped text-white">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Nomor Telepon</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($pelanggan)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['NamaPelanggan'] ?></td>
                <td><?= $row['Alamat'] ?></td>
                <td><?= $row['NomorTelepon'] ?></td>
                <td>
                  <a href="pelanggan.php?hapus=<?= $row['PelangganID'] ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Hapus pelanggan ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>