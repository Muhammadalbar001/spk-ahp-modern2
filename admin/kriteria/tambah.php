<?php
session_start();
include '../../config/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];
    $koneksi->query("INSERT INTO kriteria (nama_kriteria, bobot) VALUES ('$nama', '$bobot')");
    header('Location: index.php');
}
include '../../includes/header.php';
include '../../includes/navbar-admin.php';
?>
<div class="container">
    <h2>Tambah Kriteria</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Kriteria</label>
            <input type="text" name="nama_kriteria" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Bobot</label>
            <input type="number" name="bobot" class="form-control" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>