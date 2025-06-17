<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit;
}
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

$kriteria = $koneksi->query("SELECT * FROM kriteria ORDER BY id_kriteria");
$kriteria_arr = [];
while ($row = $kriteria->fetch_assoc()) {
    $kriteria_arr[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hapus data lama
    $koneksi->query("DELETE FROM perbandingan");

    // Simpan data baru
    foreach ($_POST['nilai'] as $key => $value) {
        list($id1, $id2) = explode('-', $key);
        $nilai = floatval($value);
        $koneksi->query("INSERT INTO perbandingan (id_kriteria_1, id_kriteria_2, nilai) VALUES ('$id1', '$id2', '$nilai')");
    }

    echo "<script>alert('Data berhasil disimpan!'); window.location='index.php';</script>";
}
?>

<h2>Input Nilai Perbandingan Kriteria</h2>
<form method="post">
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Kriteria 1</th>
                <th>Kriteria 2</th>
                <th>Nilai Perbandingan</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($kriteria_arr); $i++): ?>
                <?php for ($j = $i + 1; $j < count($kriteria_arr); $j++): ?>
                    <tr>
                        <td><?= $kriteria_arr[$i]['nama_kriteria'] ?></td>
                        <td><?= $kriteria_arr[$j]['nama_kriteria'] ?></td>
                        <td>
                            <input type="number" name="nilai[<?= $kriteria_arr[$i]['id_kriteria'] ?>-<?= $kriteria_arr[$j]['id_kriteria'] ?>]" step="0.01" min="1" max="9" required>
                        </td>
                    </tr>
                <?php endfor; ?>
            <?php endfor; ?>
        </tbody>
    </table>
    <button type="submit">Simpan</button>
</form>

<?php include '../../includes/footer.php'; ?>
