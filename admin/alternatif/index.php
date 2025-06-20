<?php
session_start();
include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';
?>
<div class="container">
    <h2>Data Alternatif</h2>
    <a href="tambah.php" class="btn btn-primary">+ Tambah Alternatif</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alternatif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = $koneksi->query("SELECT * FROM alternatif");
            while ($row = $data->fetch_assoc()) {
                echo "<tr>
          <td>{$no}</td>
          <td>{$row['nama_alternatif']}</td>
          <td>
            <a href='edit.php?id={$row['id_alternatif']}' class='btn btn-warning btn-sm'>Edit</a>
            <a href='hapus.php?id={$row['id_alternatif']}' onclick=\"return confirm('Yakin?')\" class='btn btn-danger btn-sm'>Hapus</a>
          </td>
        </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
<?php include '../../includes/footer.php'; ?>