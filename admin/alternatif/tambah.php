<?php
session_start();
include '../../config/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_alternatif'];
    $koneksi->query("INSERT INTO alternatif (nama_alternatif) VALUES ('$nama')");
    header('Location: index.php');
}
include '../../includes/header.php';
include '../../includes/navbar-admin.php';
?>
<div class="container">
    <h2>Tambah Alternatif</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Alternatif</label>
            <input type="text" name="nama_alternatif" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>