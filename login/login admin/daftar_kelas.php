<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'guru')) {
    header("Location: login_adminguru.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Kelas</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f2f5;
        margin: 0;
        padding: 20px;
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
    }
    .kelas-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        max-width: 800px;
        margin: 0 auto;
    }
    .kelas-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .kelas-card:hover {
        transform: scale(1.05);
        cursor: pointer;
    }
    .kelas-card a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
        font-size: 18px;
    }
  </style>
</head>
<body>
<button style="background: #b0bfff; "><a style="text-decoration: none; background: #6fcf97; color: white;" href="login_adminguru.html"> < Kembali</a></button>
  <h2>Pilih Kelas</h2>

  <div class="kelas-container">
    <div class="kelas-card"><a href="daftar_siswa.php?kelas=X TKJ">X TKJ</a></div>
    <div class="kelas-card"><a href="daftar_siswa.php?kelas=X TBB">X TBB</a></div>
    <div class="kelas-card"><a href="daftar_siswa.php?kelas=XI TKJ">XI TKJ</a></div>
    <div class="kelas-card"><a href="daftar_siswa.php?kelas=XI TBB">XI TBB</a></div>
    <div class="kelas-card"><a href="daftar_siswa.php?kelas=XII TKJ">XII TKJ</a></div>
    <div class="kelas-card"><a href="daftar_siswa.php?kelas=XII TBB">XII TBB</a></div>
  </div>

</body>
</html>
