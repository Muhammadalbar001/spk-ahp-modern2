<?php
require '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

echo "<div class='container mt-4'>";
echo "<h4>Input Manual Pairwise Matrix</h4><hr>";

$kriteria = $conn->query("SELECT * FROM ahp_kriteria ORDER BY id_kriteria");
$data = [];
while ($row = $kriteria->fetch_assoc()) {
    $data[] = $row;
}
$n = count($data);
?>
<form action="proses_input_manual.php" method="post">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kriteria 1</th>
                <th>Kriteria 2</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < $n; $i++): ?>
            <?php for ($j = 0; $j < $n; $j++): ?>
            <?php if ($i != $j): ?>
            <tr>
                <td><?= $data[$i]['nama'] ?></td>
                <td><?= $data[$j]['nama'] ?></td>
                <td><input type="number" name="nilai[<?= $data[$i]['id_kriteria'] ?>][<?= $data[$j]['id_kriteria'] ?>]"
                        step="0.01" class="form-control" required></td>
            </tr>
            <?php endif; ?>
            <?php endfor; ?>
            <?php endfor; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
<?php
echo "</div>";
include '../../includes/footer.php';
?>