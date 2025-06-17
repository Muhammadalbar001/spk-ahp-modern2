<?php
require '../config/koneksi.php';
require '../vendor/autoload.php';
use Dompdf\Dompdf;

$query = "
  SELECT u.nama, r.hasil_akhir
  FROM ahp_hasil r
  JOIN ahp_pengguna u ON r.id_user = u.id
  WHERE u.role = 'siswa'
  ORDER BY r.hasil_akhir DESC
";
$result = $conn->query($query);

$html = '<h3>Hasil Ranking Siswa</h3><table border="1" cellpadding="10"><tr><th>Nama</th><th>Skor</th></tr>';
while ($row = $result->fetch_assoc()) {
    $html .= "<tr><td>{$row['nama']}</td><td>{$row['hasil_akhir']}</td></tr>";
}
$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("ranking_siswa.pdf", array("Attachment" => 0));
?>