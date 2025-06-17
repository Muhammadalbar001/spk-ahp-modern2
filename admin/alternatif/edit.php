<?php
session_start();
include '../../config/koneksi.php';
$id = $_GET['id'];
$data = $koneksi->query("SELECT * FROM alternatif WHERE id_alternatif = '$id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_alternatif'];
    $koneksi->query("UPDATE alternatif SET nama_alternatif = '$nama' WHERE id_alternatif = '$id'");
    header('Location: index.php');
}

include '../../includes/header.php';
include '../../includes/navbar-admin.php';
?>
<div class="container">
    <h2>Edit Alternatif</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Alternatif</label>
            <input type="text" name="nama_alternatif" class="form-control" value="<?= $data['nama_alternatif'] ?>"
                required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>