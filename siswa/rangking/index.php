<?php
session_start();
if ($_SESSION['role'] !== 'siswa') {
    header('Location: ../../auth/login.php');
    exit;
}

include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-siswa.php';

// Ambil data ranking dari database
$query = $koneksi->query("
    SELECT ra.nilai_total, a.nama_alternatif 
    FROM ahp_rangking ra 
    JOIN alternatif a ON ra.id_alternatif = a.id_alternatif
    ORDER BY ra.nilai_total DESC
");
?>

<h2>Hasil Rangking Alternatif</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Nama Alternatif</th>
            <th>Nilai Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rank = 1;
        while ($row = $query->fetch_assoc()):
        ?>
        <tr>
            <td><?= $rank++; ?></td>
            <td><?= $row['nama_alternatif']; ?></td>
            <td><?= number_format($row['nilai_total'], 4); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../../includes/footer.php'; ?>
