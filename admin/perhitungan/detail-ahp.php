<?php
session_start();
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

echo "<h2>Detail Perhitungan AHP</h2>";
echo "<p>Menampilkan Pairwise Comparison Matrix, Eigen Vector, CI, dan CR.</p>";

// Tampilkan tabel pairwise matrix dari tabel `matriks_perbandingan`
$data = $koneksi->query("
    SELECT k1.nama_kriteria AS dari, k2.nama_kriteria AS ke, m.nilai 
    FROM matriks_perbandingan m
    JOIN kriteria k1 ON m.id_kriteria_1 = k1.id_kriteria
    JOIN kriteria k2 ON m.id_kriteria_2 = k2.id_kriteria
");

echo "<h3>Pairwise Comparison Matrix</h3>";
echo "<table border='1' cellpadding='5'><tr><th>Dari</th><th>Ke</th><th>Nilai</th></tr>";
while ($row = $data->fetch_assoc()) {
    echo "<tr><td>{$row['dari']}</td><td>{$row['ke']}</td><td>{$row['nilai']}</td></tr>";
}
echo "</table>";

// Tambahkan perhitungan eigen, CI, CR jika sudah ada datanya
// ... disusul di tahapan lanjutan jika kamu butuh ditampilkan seperti Excel
include '../../includes/footer.php';
