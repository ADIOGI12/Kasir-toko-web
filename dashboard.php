<?php
include "header.php";
include "confing.php";

// Hitung total data barang
$totalBarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM produk"))['jml'];

// Hitung total transaksi
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM transaksi"))['jml'];

// Hitung total barang terjual
$totalTerjual = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) as jml FROM transaksi"))['jml'];

// Hitung total pelanggan
$totalPelanggan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM pelanggan"))['jml'];

// Ambil transaksi terbaru (limit 5)
$transaksi = mysqli_query(
  $koneksi,
  "SELECT t.TransaksiID, p.NamaProduk, t.Jumlah, t.Tanggal 
     FROM transaksi t 
     JOIN produk p ON t.ProdukID = p.ProdukID 
     ORDER BY t.Tanggal DESC LIMIT 5"
);
?>

<!-- Tambahkan CSS Persona 5 -->
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
    transform: scale(1.05) skew(-2deg);
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
</style>

<!-- Profil & Sapaan -->
<div class="d-flex align-items-center mb-3">
  <img src="asset/<?php echo $_SESSION['foto'] ?? 'avatar.jpeg'; ?>"
    alt="Profil" width="70" height="70"
    class="rounded-circle border me-3">

  <div>
    <h3 class="mb-0">🎭 Selamat datang, <?php echo $_SESSION['username']; ?>!</h3>
    <small class="text-muted">Take Your Heart ❤️</small>
  </div>
</div>

<hr style="border: 2px solid #e60012;">

<!-- Ringkasan Data Persona 5 Style -->
<div class="row text-center">
  <div class="col-md-3">
    <div class="p5-card p-3 mb-3">
      <h5>📦 Total Barang</h5>
      <h2><?= $totalBarang ?></h2>
      <a href="barang.php" class="btn btn-p5 mt-2">Kelola</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="p5-card p-3 mb-3">
      <h5>🛒 Total Transaksi</h5>
      <h2><?= $totalTransaksi ?></h2>
      <a href="transaksi.php" class="btn btn-p5 mt-2">Kelola</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="p5-card p-3 mb-3">
      <h5>📊 Barang Terjual</h5>
      <h2><?= $totalTerjual ?: 0 ?></h2>
      <a href="laporan.php" class="btn btn-p5 mt-2">Laporan</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="p5-card p-3 mb-3">
      <h5>👥 Pelanggan</h5>
      <h2><?= $totalPelanggan ?></h2>
      <a href="pelanggan.php" class="btn btn-p5 mt-2">Kelola</a>
    </div>
  </div>
</div>

<!-- Tabel Transaksi Terbaru -->
<div class="card mt-4">
  <div class="p5-header">📝 Transaksi Terbaru</div>
  <div class="card-body bg-dark">
    <table class="table table-dark table-striped text-center">
      <thead>
        <tr>
          <th>No</th>
          <th>Produk</th>
          <th>Jumlah</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($transaksi)): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['NamaProduk'] ?></td>
            <td><?= $row['Jumlah'] ?></td>
            <td><?= $row['Tanggal'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <a href="transaksi.php" class="btn btn-p5">📑 Lihat Semua</a>
  </div>
</div>

<?php include "footer.php"; ?>