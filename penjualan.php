<?php
include "confing.php";
include "header.php";
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
if (isset($_POST['simpan'])) {
    $pelanggan = $_POST['pelanggan'];
    $user = 1; // sementara hardcode, nanti ambil dari $_SESSION
    mysqli_query($koneksi, "INSERT INTO penjualan (TanggalPenjualan, TotalHarga, PelangganID, UserID) 
    VALUES (CURDATE(), 0, '$pelanggan', '$user')");
    $penjualan_id = mysqli_insert_id($koneksi);

    foreach ($_POST['produk'] as $i => $id_produk) {
        $jumlah = $_POST['jumlah'][$i];
        $qProduk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE ProdukID=$id_produk"));
        $subtotal = $qProduk['Harga'] * $jumlah;

        mysqli_query($koneksi, "INSERT INTO detailpenjualan (PenjualanID, ProdukID, JumlahProduk, Subtotal)
        VALUES ('$penjualan_id','$id_produk','$jumlah','$subtotal')");

        mysqli_query($koneksi, "UPDATE produk SET Stok = Stok - $jumlah WHERE ProdukID=$id_produk");
    }

    mysqli_query($koneksi, "UPDATE penjualan 
    SET TotalHarga = (SELECT SUM(Subtotal) FROM detailpenjualan WHERE PenjualanID=$penjualan_id)
    WHERE PenjualanID=$penjualan_id");

    echo "<div class='alert alert-success'>Transaksi berhasil!</div>";
}
?>

<h2 class="mb-3">Transaksi Penjualan</h2>
<form method="post">
  <div class="mb-3">
    <label>Pelanggan</label>
    <select name="pelanggan" class="form-select">
      <?php
      $p = mysqli_query($koneksi, "SELECT * FROM pelanggan");
      while ($row = mysqli_fetch_assoc($p)) {
          echo "<option value='".$row['PelangganID']."'>".$row['NamaPelanggan']."</option>";
      }
      ?>
    </select>
  </div>

  <h5>Produk</h5>
  <?php
  $q = mysqli_query($koneksi, "SELECT * FROM produk WHERE Stok > 0");
  while ($row = mysqli_fetch_assoc($q)) {
      echo "<div class='form-check mb-2'>
              <input class='form-check-input' type='checkbox' name='produk[]' value='".$row['ProdukID']."'>
              <label class='form-check-label'>".$row['NamaProduk']." (Rp ".number_format($row['Harga'],0,',','.').")</label>
              <input type='number' name='jumlah[]' class='form-control mt-1' value='1' min='1'>
            </div>";
  }
  ?>

  <button type="submit" name="simpan" class="btn btn-primary mt-3">Simpan Transaksi</button>
</form>

<?php include "footer.php"; ?>