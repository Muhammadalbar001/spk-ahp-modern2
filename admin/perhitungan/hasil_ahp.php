<?php
include '../../includes/session-check.php';
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

$query = "SELECT k.nama_kriteria, e.nilai_eigen FROM ahp_kriteria k JOIN ahp_eigen e ON k.id_kriteria = e.id_kriteria";
$result = mysqli_query($conn, $query);

$labels = [];
$data = [];
?>

<h2>Hasil Perhitungan AHP</h2>
<?php if (mysqli_num_rows($result) > 0): ?>
<table border="1" cellpadding="5">
    <tr>
        <th>Kriteria</th>
        <th>Nilai Eigen</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['nama_kriteria'] ?></td>
        <td><?= $row['nilai_eigen'] ?></td>
    </tr>
    <?php $labels[] = $row['nama_kriteria']; $data[] = $row['nilai_eigen']; ?>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p>Belum ada hasil perhitungan AHP yang disimpan.</p>
<?php endif; ?>

<?php if (!empty($labels)): ?>
<h4>Visualisasi Grafik Eigen</h4>
<canvas id="eigenChart" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('eigenChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Nilai Eigen',
            data: <?= json_encode($data) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<br><a href="cetak_hasil_ahp.php" target="_blank"><button>Cetak Hasil PDF</button></a>
<?php endif; ?>

<?php include '../../includes/footer.php'; ?>