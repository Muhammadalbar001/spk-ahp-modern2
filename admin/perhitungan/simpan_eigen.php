<?php
// ===== File: admin/perhitungan/simpan_eigen.php =====
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kriteria = $_POST['kriteria'];
    $eigen = $_POST['eigen'];

    foreach ($kriteria as $index => $id_kriteria) {
        $nilai_eigen = $eigen[$index];

        $cek = mysqli_query($conn, "SELECT * FROM ahp_eigen WHERE id_kriteria='$id_kriteria'");
        if (mysqli_num_rows($cek) > 0) {
            mysqli_query($conn, "UPDATE ahp_eigen SET nilai_eigen='$nilai_eigen' WHERE id_kriteria='$id_kriteria'");
        } else {
            mysqli_query($conn, "INSERT INTO ahp_eigen (id_kriteria, nilai_eigen) VALUES ('$id_kriteria', '$nilai_eigen')");
        }
    }
    header("Location: grafik_eigen.php?status=sukses");
    exit();
} else {
    echo "Akses tidak valid.";
}
?>