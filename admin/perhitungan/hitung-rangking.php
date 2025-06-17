<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit;
}

include '../../config/koneksi.php';
include '../../includes/header.php';
include '../../includes/navbar-admin.php';

// Ambil data alternatif dan kriteria
$alternatif = $koneksi->query("SELECT * FROM alternatif");
$kriteria = $koneksi->query("SELECT * FROM kriteria");

// Ambil bobot kriteria
$bobot_result = $koneksi->query("SELECT * FROM bobot_kriteria");
$bobot = [];
while ($row = $bobot_result->fetch_assoc()) {
    $bobot[$row['id_kriteria']] = $row['bobot'];
}

// Bangun matriks penilaian alternatif-kriteria
$matrix = [];
$max = [];

while ($a = $alternatif->fetch_assoc()) {
    $id_alt = $a['id_alternatif'];
    $matrix[$id_alt] = [];
    $kriteria->data_seek(0);
    while ($k = $kriteria->fetch_assoc()) {
        $id_krit = $k['id_kriteria'];
        $nilai = $koneksi->query("SELECT nilai FROM nilai WHERE id_alternatif='$id_alt' AND id_kriteria='$id_krit'")->fetch_assoc();
        $val = $nilai ? $nilai['nilai'] : 0;
        $matrix[$id_alt][$id_krit] = $val;
        if (!isset($max[$id_krit]) || $val > $max[$id_krit]) {
            $max[$id_krit] = $val;
        }
    }
}

// Normalisasi dan Hitung Total
$hasil_akhir = [];
foreach ($matrix as $id_alt => $nilai_kriteria) {
    $total = 0;
    foreach ($nilai_kriteria as $id_krit => $val) {
        $normal = $max[$id_krit] == 0 ? 0 : $val / $max[$id_krit];
        $total += $normal * $bobot[$id_krit];
    }
    $hasil_akhir[$id_alt] = round($total, 4);
    // Simpan ke DB
    $cek = $koneksi->query("SELECT * FROM hasil_akhir WHERE id_alternatif = '$id_alt'");
    if ($cek->num_rows > 0) {
        $koneksi->query("UPDATE hasil_akhir SET nilai_akhir = '$total' WHERE id_alternatif = '$id_alt'");
    } else {
        $koneksi->query("INSERT INTO hasil_akhir (id_alternatif, nilai_akhir) VALUES ('$id_alt', '$total')");
    }
}
?>

<h2>Hasil Normalisasi dan Ranking</h2>
<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Nama Alternatif</th>
            <th>Nilai Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        arsort($hasil_akhir); // Urutkan dari tertinggi
        foreach ($hasil_akhir as $id_alt => $nilai) {
            $nama = $koneksi->query("SELECT nama_alternatif FROM alternatif WHERE id_alternatif='$id_alt'")->fetch_assoc();
            echo "<tr><td>{$nama['nama_alternatif']}</td><td>{$nilai}</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include '../../includes/footer.php'; ?>
