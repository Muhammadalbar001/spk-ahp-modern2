<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit;
}

include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

// Ambil nilai
$nilai = $koneksi->query("
    SELECT n.id_nilai, a.nama_alternatif, k.nama_kriteria, n.nilai 
    FROM nilai n 
    JOIN alternatif a ON n.id_alternatif = a.id_alternatif 
    JOIN kriteria k ON n.id_kriteria = k.id_kriteria
");
?>

<h2>Nilai Alternatif per Kriteria</h2>
<a href="tambah.php">Tambah Nilai</a>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Alternatif</th>
            <th>Kriteria</th>
            <th>Nilai</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while($row = $nilai->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_alternatif'] ?></td>
            <td><?= $row['nama_kriteria'] ?></td>
            <td><?= $row['nilai'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_nilai'] ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row['id_nilai'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../../includes/footer.php'; ?>
