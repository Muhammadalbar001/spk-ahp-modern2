<?php
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

function fetchCriteria($conn) {
  $sql = "SELECT * FROM kriteria";
  $result = $conn->query($sql);
  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
  return $data;
}

function fetchPairwiseMatrix($conn) {
  $sql = "SELECT * FROM ahp_perbandingan";
  $result = $conn->query($sql);
  $matrix = [];
  while ($row = $result->fetch_assoc()) {
    $matrix[$row['kriteria1']][$row['kriteria2']] = $row['nilai'];
  }
  return $matrix;
}

function normalizeMatrix($matrix, $criteria) {
  $size = count($criteria);
  $sums = array_fill(0, $size, 0);
  foreach ($matrix as $i => $row) {
    foreach ($row as $j => $value) {
      $sums[$j] += $value;
    }
  }
  $normalized = [];
  foreach ($matrix as $i => $row) {
    foreach ($row as $j => $value) {
      $normalized[$i][$j] = $value / $sums[$j];
    }
  }
  return $normalized;
}

function calculatePriorityVector($normalized, $criteria) {
  $size = count($criteria);
  $vector = [];
  foreach ($normalized as $i => $row) {
    $vector[$i] = array_sum($row) / $size;
  }
  return $vector;
}

function calculateConsistency($matrix, $priorityVector, $criteria) {
  $size = count($criteria);
  $lambda_max = 0;
  foreach ($matrix as $i => $row) {
    $sum = 0;
    foreach ($row as $j => $value) {
      $sum += $value * $priorityVector[$j];
    }
    $lambda_max += $sum / $priorityVector[$i];
  }
  $lambda_max /= $size;
  $CI = ($lambda_max - $size) / ($size - 1);
  $RI = [0.00, 0.00, 0.58, 0.90, 1.12, 1.24, 1.32];
  $CR = ($RI[$size - 1] > 0) ? ($CI / $RI[$size - 1]) : 0;
  return ['lambda' => $lambda_max, 'CI' => $CI, 'CR' => $CR];
}

$criteria = fetchCriteria($conn);
$matrix = fetchPairwiseMatrix($conn);
$normalized = normalizeMatrix($matrix, $criteria);
$priorityVector = calculatePriorityVector($normalized, $criteria);
$consistency = calculateConsistency($matrix, $priorityVector, $criteria);
?>

<div class="container mt-4">
    <h2>Perhitungan AHP (Eigen, CI, CR)</h2>
    <hr>

    <h4>Prioritas Kriteria (Eigen Vector)</h4>
    <table border="1" cellpadding="8">
        <tr>
            <th>Kriteria</th>
            <th>Prioritas</th>
        </tr>
        <?php foreach ($criteria as $index => $k): ?>
        <tr>
            <td><?= $k['nama_kriteria'] ?></td>
            <td><?= round($priorityVector[$index], 4) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h4>Perhitungan Konsistensi</h4>
    <p>λ Max = <?= round($consistency['lambda'], 4) ?></p>
    <p>CI = <?= round($consistency['CI'], 4) ?></p>
    <p>CR = <?= round($consistency['CR'], 4) ?></p>
    <p><strong>
            <?php if ($consistency['CR'] <= 0.1): ?>
            Matriks konsisten.
            <?php else: ?>
            Matriks tidak konsisten, harap periksa kembali nilai perbandingan.
            <?php endif; ?>
        </strong></p>
</div>

<?php include '../../includes/footer.php'; ?>