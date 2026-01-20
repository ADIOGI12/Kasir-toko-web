<?php
include "confing.php";
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

// Tambah Barang
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  mysqli_query($koneksi, "INSERT INTO produk (NamaProduk,Harga,Stok) VALUES ('$nama','$harga','$stok')");
}

// Hapus Barang
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM produk WHERE ProdukID='$id'");
}

$barang = mysqli_query($koneksi, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Data Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #111;
      color: #fff;
      font-family: 'Montserrat', sans-serif;
    }

    .p5-card {
      border-radius: 15px;
      border: 3px solid #fff;
      background: linear-gradient(145deg, #e60012, #000);
      color: white;
      box-shadow: 5px 5px 0px #000, 10px 10px 0px #e60012;
      transform: skew(-2deg);
      transition: 0.3s;
    }

    .p5-card:hover {
      transform: scale(1.03) skew(-2deg);
      box-shadow: 8px 8px 0px #000, 14px 14px 0px #e60012;
    }

    .p5-header {
      background: #e60012;
      color: white;
      padding: 15px;
      text-transform: uppercase;
      font-weight: bold;
      border-left: 5px solid #fff;
    }

    .btn-p5 {
      background: #e60012;
      border: none;
      font-weight: bold;
      color: white;
      transition: 0.2s;
    }

    .btn-p5:hover {
      background: white;
      color: #e60012;
      border: 2px solid #e60012;
    }

    table.table tbody tr:hover {
      background-color: #ff1a1a;
      color: #fff;
      transition: 0.3s;
    }

    input,
    select {
      background: #222;
      color: #fff;
      border: 2px solid #e60012;
    }

    input::placeholder {
      color: #ccc;
    }
  </style>
</head>

<body>
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">📦 Data Barang</h2>
      <a href="dashboard.php" class="btn btn-p5">⬅ Kembali ke Dashboard</a>
    </div>

    <!-- Form Tambah Barang -->
    <div class="card p5-card mb-4">
      <div class="p5-header">Tambah Barang</div>
      <div class="card-body">
        <form method="post" class="row g-3">
          <div class="col-md-4">
            <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required>
          </div>
          <div class="col-md-3">
            <input type="number" name="harga" class="form-control" placeholder="Harga" required>
          </div>
          <div class="col-md-2">
            <input type="number" name="stok" class="form-control" placeholder="Stok" required>
          </div>
          <div class="col-md-3">
            <button type="submit" name="tambah" class="btn btn-p5 w-100">+ Tambah</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabel Barang -->
    <div class="card p5-card">
      <div class="p5-header">Daftar Barang</div>
      <div class="card-body p-0 table-responsive">
        <table class="table table-dark table-striped mb-0 text-center align-middle">
          <thead>
            <tr>
              <th style="width: 50px;">No</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Stok</th>
              <th style="width: 150px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            while ($row = mysqli_fetch_assoc($barang)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['NamaProduk'] ?></td>
                <td>Rp <?= number_format($row['Harga'], 0, ',', '.') ?></td>
                <td><?= $row['Stok'] ?></td>
                <td>
                  <a href="produk_hapus.php?id=<?= $row['ProdukID'] ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Yakin ingin hapus produk ini?')">🗑 Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>