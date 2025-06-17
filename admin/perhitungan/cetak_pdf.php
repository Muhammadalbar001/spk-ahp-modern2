<?php
require '../../config/koneksi.php';
require '../../vendor/autoload.php';

use Dompdf\Dompdf;

$query = "SELECT * FROM ahp_perbandingan ORDER BY kriteria1, kriteria2";
$result = $conn->query($query);

$html = '<h3>Pairwise Matrix</h3><table border="1" cellpadding="10"><tr><th>Kriteria 1</th><th>Kriteria 2</th><th>Nilai</th></tr>';
while ($row = $result->fetch_assoc()) {
    $html .= "<tr><td>{$row['kriteria1']}</td><td>{$row['kriteria2']}</td><td>{$row['nilai']}</td></tr>";
}
$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("pairwise_matrix_admin.pdf", array("Attachment" => 0));
?>