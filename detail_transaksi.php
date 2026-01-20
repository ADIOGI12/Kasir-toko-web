<?php
session_start();
include '../koneksi.php';
if(!isset($_SESSION['UserID'])){ header('Location: ../login.php'); exit; }
if(!isset($_GET['id'])){ echo 'ID penjualan tidak ditemukan'; exit; }
$id = (int)$_GET['id'];
$pen = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM penjualan WHERE PenjualanID=$id"));
$details = mysqli_query($koneksi, "SELECT d.*, p.NamaProduk FROM detailpenjualan d JOIN produk p ON d.ProdukID=p.ProdukID WHERE d.PenjualanID=$id");
include '../includes/header.php';
?>
<div class="container">
  <h2>Detail Penjualan #<?= $id ?></h2>
  <p>Tanggal: <?= $pen['TanggalPenjualan'] ?></p>
  <table>
    <tr><th>Produk</th><th>Qty</th><th>Subtotal</th></tr>
    <?php while($d=mysqli_fetch_assoc($details)){ ?>
    <tr>
      <td><?= $d['NamaProduk'] ?></td>
      <td><?= $d['JumlahProduk'] ?></td>
      <td><?= $d['Subtotal'] ?></td>
    </tr>
    <?php } ?>
    <tr><td colspan="2">Total</td><td><?= $pen['TotalHarga'] ?></td></tr>
  </table>
  <p><a href="transaksi.php">Kembali</a></p>
</div>
<?php include '../includes/footer.php'; ?>