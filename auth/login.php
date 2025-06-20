<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $koneksi->query("SELECT * FROM pengguna WHERE username='$username' AND password='$password'");
    $data = $query->fetch_assoc();

    if ($data) {
        $_SESSION['id_pengguna'] = $data['id_pengguna'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        switch ($data['role']) {
            case 'admin':
                header('Location: ../admin/dashboard/index.php');
                break;
            case 'penilai':
                header('Location: ../penilai/dashboard/index.php');
                break;
            case 'siswa':
                header('Location: ../siswa/dashboard/index.php');
                break;
        }
    } else {
        echo "<script>alert('Login gagal!'); window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login SPK AHP</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
