<?php
// ===== File: admin/perhitungan/hitung_ci_cr.php =====
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

// Ambil semua data pairwise
$data = mysqli_query($conn, "SELECT * FROM ahp_matrix_pairwise ORDER BY kriteria1, kriteria2");
$matrix = [];
while ($row = mysqli_fetch_assoc($data)) {
    $matrix[$row['kriteria1']][$row['kriteria2']] = $row['nilai'];
}

$n = count($matrix);

// Hitung jumlah kolom
$sum_col = array_fill(0, $n, 0);
foreach ($matrix as $i => $row) {
    foreach ($row as $j => $val) {
        $sum_col[$j] += $val;
    }
}

// Normalisasi dan hitung rata-rata
$norm = $eigen = [];
for ($i = 0; $i < $n; $i++) {
    $row_sum = 0;
    for ($j = 0; $j < $n; $j++) {
        $norm[$i][$j] = $matrix[$i][$j] / $sum_col[$j];
        $row_sum += $norm[$i][$j];
    }
    $eigen[$i] = $row_sum / $n;
}

// Hitung CI dan CR
$lambda_max = 0;
for ($i = 0; $i < $n; $i++) {
    $sum_row = 0;
    for ($j = 0; $j < $n; $j++) {
        $sum_row += $matrix[$i][$j] * $eigen[$j];
    }
    $lambda_max += $sum_row / $eigen[$i];
}

$lambda_max /= $n;
$CI = ($lambda_max - $n) / ($n - 1);
$RI = [0.00, 0.00, 0.58, 0.90, 1.12, 1.24];
$CR = $CI / $RI[$n - 1];

echo "<h2>Hasil Perhitungan CI dan CR</h2>";
echo "<p>Lambda Max: " . round($lambda_max, 4) . "</p>";
echo "<p>Consistency Index (CI): " . round($CI, 4) . "</p>";
echo "<p>Consistency Ratio (CR): " . round($CR, 4) . "</p>";

if ($CR < 0.1) {
    echo "<p><b>CR diterima, konsistensi memadai.</b></p>";
} else {
    echo "<p><b>CR terlalu tinggi. Silakan perbaiki input pairwise.</b></p>";
}

include '../../includes/footer.php';
?>
