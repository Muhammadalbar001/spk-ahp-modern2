<?php
session_start();
include '../../config/koneksi.php';
$id = $_GET['id'];
$data = $koneksi->query("SELECT * FROM kriteria WHERE id_kriteria = '$id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama_kriteria'];
  $bobot = $_POST['bobot'];
  $koneksi->query("UPDATE kriteria SET nama_kriteria = '$nama', bobot = '$bobot' WHERE id_kriteria = '$id'");
  header('Location: index.php');
}

include '../../includes/header.php';
include '../../includes/navbar-admin.php';
?>
<div class="container">
    <h2>Edit Kriteria</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Kriteria</label>
            <input type="text" name="nama_kriteria" class="form-control" value="<?= $data['nama_kriteria'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Bobot</label>
            <input type="number" name="bobot" class="form-control" step="0.01" value="<?= $data['bobot'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>