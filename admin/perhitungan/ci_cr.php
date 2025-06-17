<?php
require '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

echo "<div class='container mt-4'>";
echo "<h4>Perhitungan CI (Consistency Index) dan CR (Consistency Ratio)</h4><hr>";

$query = "SELECT * FROM ahp_kriteria ORDER BY id_kriteria";
$result = $conn->query($query);

$kriteria = [];
while ($row = $result->fetch_assoc()) {
    $kriteria[] = $row['nama'];
}
$n = count($kriteria);

$eigen = [];
$eigenQuery = $conn->query("SELECT * FROM ahp_eigen ORDER BY id_kriteria");
while ($row = $eigenQuery->fetch_assoc()) {
    $eigen[$row['id_kriteria']] = $row['nilai'];
}

$lambdaMax = 0;
foreach ($eigen as $id_kriteria => $nilai) {
    $sumCol = 0;
    $colQuery = $conn->query("SELECT * FROM ahp_perbandingan WHERE kriteria2 = '$id_kriteria'");
    while ($row = $colQuery->fetch_assoc()) {
        $sumCol += $row['nilai'] * $eigen[$row['kriteria1']];
    }
    $lambdaMax += $sumCol;
}

$lambdaMax = round($lambdaMax, 4);
$CI = round(($lambdaMax - $n) / ($n - 1), 4);
$IR = [1 => 0.00, 2 => 0.00, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45, 10 => 1.49];
$CR = ($IR[$n] != 0) ? round($CI / $IR[$n], 4) : 0;

echo "<p><strong>Jumlah Kriteria:</strong> $n</p>";
echo "<p><strong>Lambda Max (λ Max):</strong> $lambdaMax</p>";
echo "<p><strong>Consistency Index (CI):</strong> $CI</p>";
echo "<p><strong>Consistency Ratio (CR):</strong> $CR</p>";

echo ($CR <= 0.1) 
    ? "<div class='alert alert-success'>Perbandingan konsisten (CR ≤ 0.1)</div>"
    : "<div class='alert alert-danger'>Perbandingan tidak konsisten (CR > 0.1)</div>";

echo "</div>";
include '../../includes/footer.php';
?>