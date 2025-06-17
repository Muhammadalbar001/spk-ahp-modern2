<?php
session_start();
if ($_SESSION['role'] !== 'penilai') {
    header('Location: ../../auth/login.php');
    exit;
}
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-penilai.php';

$alternatif = $koneksi->query("SELECT * FROM alternatif ORDER BY id_alternatif");
$kriteria = $koneksi->query("SELECT * FROM kriteria ORDER BY id_kriteria");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hapus nilai lama terlebih dahulu jika perlu
    $koneksi->query("DELETE FROM nilai");

    // Simpan nilai baru
    foreach ($_POST['nilai'] as $id_alternatif => $kriteria_nilai) {
        foreach ($kriteria_nilai as $id_kriteria => $nilai) {
            $nilai = floatval($nilai);
            $koneksi->query("INSERT INTO nilai (id_alternatif, id_kriteria, nilai) 
                             VALUES ('$id_alternatif', '$id_kriteria', '$nilai')");
        }
    }

    echo "<script>alert('Nilai berhasil disimpan.'); window.location='input-nilai.php';</script>";
}
?>

<h2>Form Penilaian Alternatif</h2>
<form method="POST">
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Alternatif / Kriteria</th>
                <?php while ($k = $kriteria->fetch_assoc()): ?>
                    <th><?= $k['nama_kriteria'] ?></th>
                <?php endwhile; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $kriteria->data_seek(0); // reset pointer
            while ($a = $alternatif->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $a['nama_alternatif'] ?></td>
                    <?php
                    $kriteria->data_seek(0);
                    while ($k = $kriteria->fetch_assoc()):
                        ?>
                        <td>
                            <input type="number" name="nilai[<?= $a['id_alternatif'] ?>][<?= $k['id_kriteria'] ?>]" step="0.01"
                                min="0" max="100" required>
                        </td>
                    <?php endwhile; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <button type="submit">Simpan Nilai</button>
</form>

<?php include '../../includes/footer.php'; ?>