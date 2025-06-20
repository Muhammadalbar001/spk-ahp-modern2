<?php
// ===== dashboard/index.php untuk admin/siswa/penilai =====
// Misal: admin/dashboard/index.php
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';
?>
<h2>Selamat Datang, Admin</h2>
<p>Gunakan menu navigasi untuk mengelola data SPK AHP:</p>
<ul>
    <li><a href="../alternatif/index.php">🧑‍🎓 Alternatif siswa</a></li>
    <li><a href="../kriteria/index.php">⚙️ Kriteria penilaian</a></li>
    <li><a href="../perhitungan/input_pairwise.php">📊 Perhitungan AHP</a></li>
    <li><a href="../perhitungan/grafik_eigen.php">📄 Laporan hasil</a></li>
</ul>
<?php include '../../includes/footer.php'; ?>

<?php
// Untuk siswa/dashboard/index.php dan penilai/dashboard/index.php tinggal ubah teks sesuai role dan navbar
?>