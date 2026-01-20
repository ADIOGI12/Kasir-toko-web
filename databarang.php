<?php
include "confing.php";
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

// hitung jumlah barang
$totalBarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM produk"))['jml'];

// hitung jumlah transaksi
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM transaksi"))['jml'];

// ambil produk terbaru (limit 5)
$produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY ProdukID DESC LIMIT 5");

// ambil transaksi terbaru (limit 5)
$transaksi = mysqli_query($koneksi, "SELECT t.TransaksiID, t.Tanggal, p.NamaProduk, t.Jumlah 
                                    FROM transaksi t 
                                    JOIN produk p ON t.ProdukID = p.ProdukID 
                                    ORDER BY t.TransaksiID DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container py-4">
    <h3>Welcome, <?= $_SESSION['username']; ?> 👋</h3>
    <hr>

    <!-- Card Statistik -->
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card text-bg-primary shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Jumlah Barang</h5>
            <p class="display-6"><?= $totalBarang ?></p>
            <a href="barang.php" class="btn btn-light btn-sm">Lihat Barang</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card text-bg-success shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Jumlah Transaksi</h5>
            <p class="display-6"><?= $totalTransaksi ?></p>
            <a href="transaksi.php" class="btn btn-light btn-sm">Lihat Transaksi</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Produk Terbaru -->
    <div class="card mb-4">
      <div class="card-header bg-dark text-white">Produk Terbaru</div>
      <div class="card-body p-0">
        <table class="table table-striped mb-0">
          <thead class="table-dark">
            <tr>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Stok</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($produk)): ?>
              <tr>
                <td><?= $row['NamaProduk'] ?></td>
                <td>Rp <?= number_format($row['Harga'], 0, ',', '.') ?></td>
                <td><?= $row['Stok'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="card mb-4">
      <div class="card-header bg-dark text-white">Transaksi Terbaru</div>
      <div class="card-body p-0">
        <table class="table table-striped mb-0">
          <thead class="table-dark">
            <tr>
              <th>Tanggal</th>
              <th>Produk</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($t = mysqli_fetch_assoc($transaksi)): ?>
              <tr>
                <td><?= $t['Tanggal'] ?></td>
                <td><?= $t['NamaProduk'] ?></td>
                <td><?= $t['Jumlah'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</body>

</html>