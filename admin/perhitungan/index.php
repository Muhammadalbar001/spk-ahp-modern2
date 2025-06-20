<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit;
}

include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

// Ambil semua kriteria
$query = $koneksi->query("SELECT * FROM kriteria ORDER BY id_kriteria");
$kriteria = [];
while ($row = $query->fetch_assoc()) {
    $kriteria[] = $row;
}
$jumlah = count($kriteria);

// Ambil nilai perbandingan
$matriks = [];
for ($i = 0; $i < $jumlah; $i++) {
    for ($j = 0; $j < $jumlah; $j++) {
        if ($i == $j) {
            $matriks[$i][$j] = 1;
        } else {
            $id1 = $kriteria[$i]['id_kriteria'];
            $id2 = $kriteria[$j]['id_kriteria'];

            $result = $koneksi->query("SELECT nilai FROM perbandingan WHERE id_kriteria_1 = '$id1' AND id_kriteria_2 = '$id2'");
            if ($row = $result->fetch_assoc()) {
                $matriks[$i][$j] = $row['nilai'];
            } else {
                $result = $koneksi->query("SELECT nilai FROM perbandingan WHERE id_kriteria_1 = '$id2' AND id_kriteria_2 = '$id1'");
                $row = $result->fetch_assoc();
                $matriks[$i][$j] = 1 / $row['nilai'];
            }
        }
    }
}

// Hitung total kolom
$totalKolom = array_fill(0, $jumlah, 0);
for ($j = 0; $j < $jumlah; $j++) {
    for ($i = 0; $i < $jumlah; $i++) {
        $totalKolom[$j] += $matriks[$i][$j];
    }
}

// Normalisasi dan hitung bobot
$normal = [];
$bobot = array_fill(0, $jumlah, 0);
for ($i = 0; $i < $jumlah; $i++) {
    for ($j = 0; $j < $jumlah; $j++) {
        $normal[$i][$j] = $matriks[$i][$j] / $totalKolom[$j];
        $bobot[$i] += $normal[$i][$j];
    }
    $bobot[$i] /= $jumlah;
}

// Hitung CI dan CR
$lambdaMax = 0;
for ($i = 0; $i < $jumlah; $i++) {
    $sum = 0;
    for ($j = 0; $j < $jumlah; $j++) {
        $sum += $matriks[$i][$j] * $bobot[$j];
    }
    $lambdaMax += $sum / $bobot[$i];
}
$lambdaMax /= $jumlah;
$ci = ($lambdaMax - $jumlah) / ($jumlah - 1);
$ri = [0.00, 0.00, 0.58, 0.90, 1.12, 1.24, 1.32]; // untuk n=1 s.d. 7
$cr = ($jumlah <= 7) ? $ci / $ri[$jumlah - 1] : 0;

?>

<h2>Perhitungan AHP</h2>

<h3>Matriks Perbandingan</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Kriteria</th>
            <?php foreach ($kriteria as $k) echo "<th>{$k['nama_kriteria']}</th>"; ?>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0; $i < $jumlah; $i++): ?>
            <tr>
                <td><?= $kriteria[$i]['nama_kriteria'] ?></td>
                <?php for ($j = 0; $j < $jumlah; $j++): ?>
                    <td><?= round($matriks[$i][$j], 3) ?></td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>

<h3>Normalisasi Matriks & Bobot</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Kriteria</th>
            <?php foreach ($kriteria as $k) echo "<th>{$k['nama_kriteria']}</th>"; ?>
            <th>Bobot</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0; $i < $jumlah; $i++): ?>
            <tr>
                <td><?= $kriteria[$i]['nama_kriteria'] ?></td>
                <?php for ($j = 0; $j < $jumlah; $j++): ?>
                    <td><?= round($normal[$i][$j], 3) ?></td>
                <?php endfor; ?>
                <td><strong><?= round($bobot[$i], 3) ?></strong></td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>
<a href="ci_cr.php" class="btn btn-primary">Lihat Perhitungan CI/CR</a>
<a href="cetak_pdf.php" target="_blank" class="btn btn-danger">Cetak PDF Pairwise Matrix</a>

<h3>Konsistensi</h3>
<p>λ max: <?= round($lambdaMax, 3) ?></p>
<p>CI: <?= round($ci, 3) ?></p>
<p>CR: <?= round($cr, 3) ?> <?= ($cr < 0.1) ? "(Konsisten)" : "(Tidak Konsisten)" ?></p>

<?php include '../../includes/footer.php'; ?>
