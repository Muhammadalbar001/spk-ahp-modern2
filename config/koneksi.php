<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'spk_ahp'; // Ganti jika nama database kamu berbeda

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
?>
