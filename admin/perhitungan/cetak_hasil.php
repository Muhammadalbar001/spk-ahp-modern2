<?php
// ===== File: admin/perhitungan/cetak_hasil.php =====
require '../../vendor/autoload.php';
include '../../config/koneksi.php';

use Dompdf\Dompdf;

$sql = "SELECT k.nama_kriteria, e.nilai_eigen FROM ahp_kriteria k JOIN ahp_eigen e ON k.id_kriteria = e.id_kriteria";
$result = mysqli_query($conn, $sql);

$html = "<h2>Hasil Perhitungan AHP</h2><table border='1' cellpadding='5'><tr><th>Kriteria</th><th>Eigen Vector</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr><td>{$row['nama_kriteria']}</td><td>{$row['nilai_eigen']}</td></tr>";
}
$html .= "</table>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("hasil_ahp.pdf", ["Attachment" => 0]);
?>