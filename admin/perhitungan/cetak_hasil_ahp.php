<?php
require '../../vendor/autoload.php';
require '../../config/koneksi.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
?>
<h2>Hasil Perhitungan AHP</h2>
<?php
$sql = "SELECT k.nama_kriteria, e.nilai_eigen FROM ahp_kriteria k JOIN ahp_eigen e ON k.id_kriteria=e.id_kriteria";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo '<table border="1" cellpadding="5"><tr><th>Kriteria</th><th>Nilai Eigen</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['nama_kriteria']}</td><td>{$row['nilai_eigen']}</td></tr>";
    }
    echo '</table>';
} else {
    echo '<p>Data belum tersedia.</p>';
}
$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('hasil_ahp.pdf', ['Attachment' => false]);
?>