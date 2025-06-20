<?php
session_start();
if ($_SESSION['role'] !== 'penilai') {
    header('Location: ../../auth/login.php');
    exit;
}

include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-penilai.php';

// Ambil semua kriteria
$kriteria = $koneksi->query("SELECT * FROM kriteria");
$kriteria_array = [];
while ($row = $kriteria->fetch_assoc()) {
    $kriteria_array[] = $row;
}
?>

<h2>Perbandingan Kriteria</h2>

<form method="post" action="proses.php">
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Kriteria 1</th>
                <th>Nilai Perbandingan</th>
                <th>Kriteria 2</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($kriteria_array); $i++): ?>
                <?php for ($j = $i + 1; $j < count($kriteria_array); $j++): ?>
                    <tr>
                        <td><?= $kriteria_array[$i]['nama_kriteria'] ?></td>
                        <td>
                            <input type="number" name="nilai[<?= $kriteria_array[$i]['id_kriteria'] ?>][<?= $kriteria_array[$j]['id_kriteria'] ?>]" min="1" max="9" required>
                        </td>
                        <td><?= $kriteria_array[$j]['nama_kriteria'] ?></td>
                    </tr>
                <?php endfor; ?>
            <?php endfor; ?>
        </tbody>
    </table>
    <br>
    <button type="submit" name="simpan">Simpan Perbandingan</button>
</form>

<?php include '../../includes/footer.php'; ?>
