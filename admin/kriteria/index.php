<?php
session_start();
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';
?>
<div class="container">
    <h2>Data Kriteria</h2>
    <a href="tambah.php" class="btn btn-primary">+ Tambah Kriteria</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = $koneksi->query("SELECT * FROM kriteria");
            while ($row = $data->fetch_assoc()) {
                echo "<tr>
          <td>{$no}</td>
          <td>{$row['nama_kriteria']}</td>
          <td>{$row['bobot']}</td>
          <td>
            <a href='edit.php?id={$row['id_kriteria']}' class='btn btn-warning btn-sm'>Edit</a>
            <a href='hapus.php?id={$row['id_kriteria']}' onclick=\"return confirm('Yakin?')\" class='btn btn-danger btn-sm'>Hapus</a>
          </td>
        </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
<?php include '../../includes/footer.php'; ?>