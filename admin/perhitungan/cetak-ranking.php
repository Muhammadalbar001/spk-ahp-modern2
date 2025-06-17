<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;

include '../../config/koneksi.php';

$hasil = $koneksi->query("
    SELECT a.nama_alternatif, h.nilai_akhir 
    FROM hasil_akhir h
    JOIN alternatif a ON h.id_alternatif = a.id_alternatif
    ORDER BY h.nilai_akhir DESC
");

$html = '<h2 style="text-align:center;">Laporan Hasil Ranking SPK AHP</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">';
$html .= '<thead><tr><th>Peringkat</th><th>Nama Alternatif</th><th>Nilai Akhir</th></tr></thead><tbody>';

$rank = 1;
while ($row = $hasil->fetch_assoc()) {
    $html .= "<tr><td>{$rank}</td><td>{$row['nama_alternatif']}</td><td>".round($row['nilai_akhir'], 4)."</td></tr>";
    $rank++;
}
$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("ranking_ahp.pdf", ["Attachment" => false]);
