<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

$nisn = $_POST['nisn'];
$nama = $_POST['nama'];

$sql = "SELECT * FROM siswa WHERE nisn='$nisn' AND nama='$nama'";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $_SESSION['wali'] = $row['id']; // simpan ID siswa
    $_SESSION['nama_siswa'] = $row['nama'];

    header("Location: wali.php");
} else {
    echo "Login gagal! NISN atau Nama salah.";
}
?>
