<?php
session_start();
include '../../config/koneksi.php';
$id = $_GET['id'];
$koneksi->query("DELETE FROM kriteria WHERE id_kriteria = '$id'");
header('Location: index.php');
?>
