<?php
include "header.php";
include "confing.php";

$laporan = mysqli_query(
    $koneksi,
    "SELECT t.TransaksiID, p.NamaProduk, t.Jumlah, t.Tanggal 
     FROM transaksi t 
     JOIN produk p ON t.ProdukID = p.ProdukID 
     ORDER BY t.Tanggal DESC"
);
?>

<!-- CSS Persona 5 -->
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
</style>

<div class="container py-4">
  <div class="card p5-card shadow-lg border-0">
    <div class="p5-header d-flex justify-content-between align-items-center">
      <h3 class="mb-0">📑 Laporan Transaksi</h3>
      <a href="dashboard.php" class="btn btn-p5 btn-sm">⬅ Kembali</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-dark table-striped text-center align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Produk</th>
              <th>Jumlah</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; while($row = mysqli_fetch_assoc($laporan)): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['NamaProduk'] ?></td>
              <td><?= $row['Jumlah'] ?></td>
              <td><?= $row['Tanggal'] ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <a href="transaksi.php" class="btn btn-p5 mt-3">📑 Lihat Semua</a>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
