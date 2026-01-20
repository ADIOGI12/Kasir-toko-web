<?php
include "confing.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Tambah Transaksi
if (isset($_POST['simpan'])) {
    $produkID = $_POST['produk'];
    $jumlah   = $_POST['jumlah'];
    mysqli_query($koneksi, "INSERT INTO transaksi (ProdukID, Jumlah) VALUES ('$produkID', '$jumlah')");
}

// Hapus Transaksi
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE TransaksiID='$id'");
    header("Location: transaksi.php");
    exit();
}

// Ambil data produk untuk dropdown
$produk = mysqli_query($koneksi, "SELECT * FROM produk");

// Ambil data transaksi
$transaksi = mysqli_query(
    $koneksi,
    "SELECT t.TransaksiID, p.NamaProduk, t.Jumlah, t.Tanggal
     FROM transaksi t
     JOIN produk p ON t.ProdukID = p.ProdukID
     ORDER BY t.Tanggal DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi</title>
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
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>🛒 Transaksi</h3>
            <a href="dashboard.php" class="btn btn-p5">⬅ Kembali</a>
        </div>

        <!-- Form Transaksi -->
        <div class="card p5-card mb-4">
            <div class="p5-header">Tambah Transaksi</div>
            <div class="card-body">
                <form method="post" class="row g-3">
                    <div class="col-md-6">
                        <select name="produk" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php while ($row = mysqli_fetch_assoc($produk)): ?>
                                <option value="<?= $row['ProdukID'] ?>">
                                    <?= $row['NamaProduk'] ?> (Stok: <?= $row['Stok'] ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="simpan" class="btn btn-p5 w-100">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="card p5-card mb-4">
            <div class="p5-header">Daftar Transaksi</div>
            <div class="card-body table-responsive">
                <table class="table table-dark table-striped text-center align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
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
                                <td>
                                    <a href="transaksi_edit.php?id=<?= $row['TransaksiID'] ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                                    <a href="transaksi.php?hapus=<?= $row['TransaksiID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus transaksi ini?')">🗑 Hapus</a>
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