<?php
$host = "localhost";
$name = "root";
$pass = "";
$db = "db_laundry_aryo";

$config = mysqli_connect($host, $name, $pass, $db);

if (!$config) {
    echo "Koneksi Gagal";
}