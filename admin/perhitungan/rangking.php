<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit;
}
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

$hasil = $koneksi->query("
    SELECT a.nama_alternatif, h.nilai_akhir 
    FROM hasil_akhir h
    JOIN alternatif a ON h.id_alternatif = a.id_alternatif
    ORDER BY h.nilai_akhir DESC
");
?>

<h2>Hasil Ranking AHP</h2>
<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Peringkat</th>
            <th>Nama Alternatif</th>
            <th>Nilai Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rank = 1;
        while ($row = $hasil->fetch_assoc()):
        ?>
            <tr>
                <td><?= $rank++ ?></td>
                <td><?= $row['nama_alternatif'] ?></td>
                <td><?= round($row['nilai_akhir'], 4) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<a href="cetak-ranking.php" target="_blank" class="btn btn-primary">Cetak PDF</a>

<?php include '../../includes/footer.php'; ?>
