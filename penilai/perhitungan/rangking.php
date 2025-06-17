<?php
session_start();
if ($_SESSION['role'] !== 'penilai') {
    header("Location: ../../auth/login.php");
    exit;
}
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-penilai.php';

$hasil = $koneksi->query("
    SELECT a.nama_alternatif, h.nilai_akhir 
    FROM hasil_akhir h
    JOIN alternatif a ON h.id_alternatif = a.id_alternatif
    ORDER BY h.nilai_akhir DESC
");
?>

<h2>Hasil Ranking AHP (Penilai)</h2>
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

<?php include '../../includes/footer.php'; ?>
