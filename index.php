<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard/index.php");
        exit;
    } elseif ($_SESSION['role'] == 'siswa') {
        header("Location: siswa/dashboard/index.php");
        exit;
    } elseif ($_SESSION['role'] == 'penilai') {
        header("Location: penilai/dashboard/index.php");
        exit;
    }
} else {
    header("Location: auth/login.php");
    exit;
}
?>
