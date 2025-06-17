<?php
// ===== File: admin/perhitungan/input_pairwise.php =====
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

// Ambil semua kriteria
$sql = "SELECT * FROM ahp_kriteria ORDER BY id_kriteria";
$result = mysqli_query($conn, $sql);
$kriteria = [];
while ($row = mysqli_fetch_assoc($result)) {
    $kriteria[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simpan input pairwise ke DB
    mysqli_query($conn, "DELETE FROM ahp_nilai_perbandingan_kriteria");
    foreach ($_POST['nilai'] as $i => $row) {
        foreach ($row as $j => $val) {
            $id1 = $kriteria[$i]['id_kriteria'];
            $id2 = $kriteria[$j]['id_kriteria'];
            mysqli_query($conn, "INSERT INTO ahp_nilai_perbandingan_kriteria (id_kriteria1, id_kriteria2, nilai) VALUES ('$id1', '$id2', '$val')");
        }
    }
    echo "<p>Data pairwise berhasil disimpan. <a href='hasil_ahp.php'>Lihat hasil AHP</a></p>";
}
?>
<h2>Input Matriks Perbandingan Kriteria</h2>
<form method="POST">
    <table border="1" cellpadding="5">
        <tr>
            <th></th>
            <?php foreach ($kriteria as $k) echo "<th>{$k['nama_kriteria']}</th>"; ?>
        </tr>
        <?php foreach ($kriteria as $i => $baris) {
    echo "<tr><th>{$baris['nama_kriteria']}</th>";
    foreach ($kriteria as $j => $kolom) {
        $val = ($i == $j) ? 1 : '';
        echo "<td><input type='number' step='any' name='nilai[$i][$j]' value='$val' required></td>";
    }
    echo "</tr>";
} ?>
    </table><br>
    <button type="submit">Simpan dan Hitung</button>
</form>
<?php include '../../includes/footer.php'; ?>