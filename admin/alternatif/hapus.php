<?php
session_start();
include '../../config/koneksi.php';
$id = $_GET['id'];
$koneksi->query("DELETE FROM alternatif WHERE id_alternatif = '$id'");
header('Location: index.php');
?>
