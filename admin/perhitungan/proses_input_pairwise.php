<?php
// ===== File: admin/perhitungan/proses_input_pairwise.php =====
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matrix = $_POST['pair'];
    $total = count($matrix);

    // Simpan ke tabel matrix pairwise (kosongkan dulu)
    mysqli_query($conn, "TRUNCATE TABLE ahp_matrix_pairwise");
    foreach ($matrix as $i => $baris) {
        foreach ($baris as $j => $nilai) {
            $query = "INSERT INTO ahp_matrix_pairwise (kriteria1, kriteria2, nilai) VALUES ($i, $j, $nilai)";
            mysqli_query($conn, $query);
        }
    }
    header("Location: hitung_ci_cr.php");
    exit;
}
?>