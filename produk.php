<?php
include "confing.php";
include "header.php";
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

// Tambah produk
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  mysqli_query($koneksi, "INSERT INTO produk (NamaProduk, Harga, Stok) VALUES ('$nama','$harga','$stok')");
  echo "<div class='alert alert-success'>Produk berhasil ditambahkan</div>";
}

// Hapus produk
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM produk WHERE ProdukID=$id");
  echo "<div class='alert alert-danger'>Produk berhasil dihapus</div>";
}
?>

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
    padding: 20px;
    margin-bottom: 20px;
  }

  .p5-card:hover {
    transform: scale(1.03) skew(-2deg);
    box-shadow: 8px 8px 0px #000, 14px 14px 0px #e60012;
  }

  .p5-header {
    background: #e60012;
    color: white;
    padding: 10px 15px;
    font-weight: bold;
    border-left: 5px solid #fff;
    margin-bottom: 15px;
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

<div class="container py-4">
  <h2 class="mb-3">📦 Data Produk</h2>

  <!-- Form Tambah Produk -->
  <div class="p5-card">
    <div class="p5-header">Tambah Produk</div>
    <form method="post" class="row g-3">
      <div class="col-md-4">
        <input type="text" name="nama" class="form-control" placeholder="Nama Produk" required>
      </div>
      <div class="col-md-3">
        <input type="number" step="0.01" name="harga" class="form-control" placeholder="Harga" required>
      </div>
      <div class="col-md-3">
        <input type="number" name="stok" class="form-control" placeholder="Stok" required>
      </div>
      <div class="col-md-2">
        <button type="submit" name="tambah" class="btn btn-p5 w-100">Tambah</button>
      </div>
    </form>
  </div>

  <!-- Tabel Produk -->
  <div class="p5-card">
    <div class="p5-header">Daftar Produk</div>
    <div class="table-responsive">
      <table class="table table-dark table-striped text-center align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = mysqli_query($koneksi, "SELECT * FROM produk");
          while ($row = mysqli_fetch_assoc($sql)) {
            echo "<tr>
                                <td>" . $row['ProdukID'] . "</td>
                                <td>" . $row['NamaProduk'] . "</td>
                                <td>Rp " . number_format($row['Harga'], 0, ',', '.') . "</td>
                                <td>" . $row['Stok'] . "</td>
                                <td>
                                  <a href='?hapus=" . $row['ProdukID'] . "' class='btn btn-p5 btn-sm' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
                                </td>
                              </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>