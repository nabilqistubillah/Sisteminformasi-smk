<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

// cek apakah sudah login sebagai wali
if (!isset($_SESSION['wali'])) {
    header("Location: login_wali.html");
    exit();
}

$id_siswa = $_SESSION['wali']; // id siswa yang disimpan saat login

$sql = "SELECT * FROM siswa WHERE id='$id_siswa'";
$result = $koneksi->query($sql);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Wali</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .card {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 15px;
      max-width: 400px;
      background: #f9f9f9;
    }
    .card h2 { margin-top: 0; }
    .info { margin-bottom: 8px; }
    .label { font-weight: bold; }
  </style>
</head>
<body>
  <h1>Dashboard Wali</h1>
  <p>Selamat datang, Wali dari <b><?php echo $data['nama']; ?></b></p>

  <div class="card">
    <h2>Data Siswa</h2>
    <div class="info"><span class="label">Nama:</span> <?php echo $data['nama']; ?></div>
    <div class="info"><span class="label">NISN:</span> <?php echo $data['nisn']; ?></div>
    <div class="info"><span class="label">Kelas:</span> <?php echo $data['kelas']; ?></div>

    <h3>Absensi</h3>
    <div class="info"><span class="label">Sakit:</span> <?php echo $data['sakit']; ?></div>
    <div class="info"><span class="label">Izin:</span> <?php echo $data['izin']; ?></div>
    <div class="info"><span class="label">Alpha:</span> <?php echo $data['alpha']; ?></div>
  </div>

  <br>
  <a href="logout_wali.php">Logout</a>
</body>
</html>
