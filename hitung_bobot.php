<?php
// Ambil bobot dari perhitungan AHP
$bobot = [];
$result = $koneksi->query("SELECT * FROM kriteria");
$jumlah = $result->num_rows;

for ($i = 0; $i < $jumlah; $i++) {
    $bobot[$i + 1] = 1 / $jumlah; // bisa diganti manual hasil perhitungan
}
foreach ($bobot as $id_kriteria => $nilai_bobot) {
    $id = intval($id_kriteria);
    $nilai = floatval($nilai_bobot);
    $cek = $koneksi->query("SELECT * FROM bobot_kriteria WHERE id_kriteria = '$id'");
    if ($cek->num_rows > 0) {
        $koneksi->query("UPDATE bobot_kriteria SET bobot = '$nilai' WHERE id_kriteria = '$id'");
    } else {
        $koneksi->query("INSERT INTO bobot_kriteria (id_kriteria, bobot) VALUES ('$id', '$nilai')");
    }
}
