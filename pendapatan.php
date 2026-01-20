<?php
include "confing.php";
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// Hitung total pendapatan
$sql_total = mysqli_query($koneksi, "SELECT SUM(TotalHarga) AS total FROM penjualan");
$total = mysqli_fetch_assoc($sql_total)['total'];

// Ambil daftar penjualan
$penjualan = mysqli_query($koneksi, "
    SELECT p.PenjualanID, p.TanggalPenjualan, p.TotalHarga, pl.NamaPelanggan, u.Username
    FROM penjualan p
    LEFT JOIN pelanggan pl ON p.PelangganID = pl.PelangganID
    LEFT JOIN user u ON p.UserID = u.UserID
    ORDER BY p.TanggalPenjualan DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pendapatan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <h2 class="mb-4">Laporan Pendapatan 💰</h2>

  <!-- Tombol kembali -->
  <a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Kembali ke Dashboard</a>

  <!-- Total Pendapatan -->
  <div class="alert alert-success fs-5">
    <strong>Total Pendapatan: Rp <?= number_format($total,0,',','.') ?></strong>
  </div>

  <!-- List Penjualan -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID Penjualan</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Petugas</th>
        <th>Total Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($penjualan)): ?>
      <tr>
        <td><?= $row['PenjualanID'] ?></td>
        <td><?= $row['TanggalPenjualan'] ?></td>
        <td><?= $row['NamaPelanggan'] ?: '-' ?></td>
        <td><?= $row['Username'] ?></td>
        <td>Rp <?= number_format($row['TotalHarga'],0,',','.') ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
