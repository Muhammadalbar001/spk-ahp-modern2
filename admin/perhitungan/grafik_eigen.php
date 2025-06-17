<?php
// ===== File: admin/perhitungan/grafik_eigen.php (lanjutan form simpan) =====
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

$sql = "SELECT k.id_kriteria, k.nama_kriteria, e.nilai_eigen FROM ahp_kriteria k LEFT JOIN ahp_eigen e ON k.id_kriteria=e.id_kriteria";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<p>Belum ada data eigen vector. Silakan lakukan perhitungan terlebih dahulu.</p>";
} else {
    echo '<form method="POST" action="simpan_eigen.php">';
    echo '<table border="1" cellpadding="5"><tr><th>Kriteria</th><th>Eigen Vector</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['nama_kriteria']}</td>
            <td><input type='hidden' name='kriteria[]' value='{$row['id_kriteria']}'>
                <input type='text' name='eigen[]' value='{$row['nilai_eigen']}' required></td>
        </tr>";
    }
    echo '</table><br><button type="submit">Simpan Hasil Eigen</button> ';
    echo '<a href="cetak_hasil_ahp.php" target="_blank"><button type="button">Cetak PDF</button></a>';
    echo '</form>';
}

include '../../includes/footer.php';
?>