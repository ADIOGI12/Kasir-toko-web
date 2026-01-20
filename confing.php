<?php
$host = "localhost";
$user = "root"; // default XAMPP
$pass = "";
$db   = "db_kasir";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
