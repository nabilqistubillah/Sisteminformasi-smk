<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];

    if ($row['role'] == 'admin') {
        header("Location: daftar_kelas.php");
    } elseif ($row['role'] == 'guru') {
        header("Location: daftar_kelas.php");
    }
} else {
    echo "Login gagal! Username atau password salah.";
}
?>
