<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kriteria = $_POST['kriteria'];
    $pairwise = $_POST['pairwise'];

    // Hapus dulu semua data sebelumnya
    $conn->query("DELETE FROM ahp_pairwise");

    foreach ($pairwise as $i => $row) {
        foreach ($row as $j => $value) {
            $id_kriteria_1 = $kriteria[$i];
            $id_kriteria_2 = $kriteria[$j];
            $nilai = (float)$value;

            $stmt = $conn->prepare("INSERT INTO ahp_pairwise (kriteria_1, kriteria_2, nilai) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $id_kriteria_1, $id_kriteria_2, $nilai);
            $stmt->execute();
        }
    }

    header("Location: hasil_ahp.php");
    exit;
}
?>