<?php
session_start();
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

$data = $koneksi->query("
    SELECT k.nama_kriteria, b.bobot 
    FROM bobot_kriteria b
    JOIN kriteria k ON b.id_kriteria = k.id_kriteria
");

$labels = [];
$values = [];
while ($row = $data->fetch_assoc()) {
    $labels[] = $row['nama_kriteria'];
    $values[] = $row['bobot'];
}
?>

<canvas id="bobotChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('bobotChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Bobot Kriteria',
            data: <?= json_encode($values) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php include '../../includes/footer.php'; ?>
