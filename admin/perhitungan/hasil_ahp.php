<?php
// ===== File: admin/perhitungan/hasil_ahp.php =====
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

// Validasi apakah data pairwise tersedia
$sql = "SELECT COUNT(*) as jumlah FROM ahp_nilai_perbandingan_kriteria";
$cek = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if ($cek['jumlah'] == 0) {
    echo "<p>Data pairwise belum diinput. Silakan isi <a href='input_pairwise.php'>di sini</a>.</p>";
    include '../../includes/footer.php';
    exit();
}

// Proses perhitungan AHP (pairwise matrix, normalisasi, eigen, CI, CR)
include '../../fungsi/perhitungan_ahp.php';
$hasil = hitungAHP($conn); // fungsi ini menghitung semua nilai dan mengembalikan array hasil

// Simpan hasil ke DB (jika belum ada)
foreach ($hasil['eigen'] as $id_kriteria => $nilai) {
    mysqli_query($conn, "REPLACE INTO ahp_eigen (id_kriteria, nilai_eigen) VALUES ('$id_kriteria', '$nilai')");
}

// Tampilkan hasilnya
?>
<h2>Hasil Perhitungan AHP</h2>
<p><b>Consistenty Index (CI):</b> <?= $hasil['ci'] ?> | <b>Consistency Ratio (CR):</b> <?= $hasil['cr'] ?>
    <?= ($hasil['cr'] <= 0.1 ? '(Konsisten)' : '(Tidak Konsisten)') ?></p>
<table border="1" cellpadding="5">
    <tr>
        <th>Kriteria</th>
        <th>Eigen Vector</th>
    </tr>
    <?php foreach ($hasil['eigen'] as $id => $nilai) {
    $nama = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_kriteria FROM ahp_kriteria WHERE id_kriteria='$id'"))['nama_kriteria'];
    echo "<tr><td>$nama</td><td>$nilai</td></tr>";
} ?>
</table>
<p><a href="cetak_hasil_ahp.php" target="_blank">Cetak Hasil ke PDF</a></p>
<?php include '../../includes/footer.php'; ?>