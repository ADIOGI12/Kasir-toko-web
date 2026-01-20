<?php
include "confing.php";

// Cek apakah ada id produk yang dikirim lewat URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // amankan input jadi integer

    // Query hapus produk
    $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE ProdukID = $id");

    if ($hapus) {
        echo "<script>
                alert('Produk berhasil dihapus!');
                window.location='barang.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus produk!');
                window.location='barang.php';
              </script>";
    }
} else {
    // Kalau tidak ada id
    header("Location: barang.php");
    exit;
}
