<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: daftar_siswa.php");
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

// Ambil daftar wali (dari tabel users)
$waliResult = $koneksi->query("SELECT id, username FROM users WHERE role = 'wali'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Siswa Baru</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f1f3f7;
      margin: 0;
      padding: 0;
    }
    h2 {
      text-align: center;
      margin-top: 40px;
    }
    form {
      max-width: 600px;
      margin: 40px auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    label {
      font-weight: bold;
    }
    input, select, textarea {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      width: 100%;
    }
    button {
      padding: 10px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background: #45a049;
    }
  </style>
</head>
<body>

  <h2>Tambah Siswa Baru</h2>

  <form action="proses_tambah_siswa.php" method="POST" enctype="multipart/form-data">
    <label>Nama Siswa:</label>
    <input type="text" name="nama" required>

    <label>NISN:</label>
    <input type="text" name="nisn" required>

    <label>Kelas:</label>
    <select name="kelas" required>
      <option value="">-- Pilih Kelas --</option>
      <option value="X TKJ">X TKJ</option>
      <option value="XI TKJ">XI TKJ</option>
      <option value="XII TKJ">XII TKJ</option>
      <option value="X TBB">X TBB</option>
      <option value="XI TBB">XI TBB</option>
      <option value="XII TBB">XII TBB</option>
    </select>

    <label>Jumlah Sakit:</label>
    <input type="number" name="sakit" value="0" min="0">

    <label>Jumlah Izin:</label>
    <input type="number" name="izin" value="0" min="0">

    <label>Jumlah Alfa:</label>
    <input type="number" name="alpha" value="0" min="0">

    <label>Keterangan:</label>
    <textarea name="keterangan" rows="3"></textarea>

    <label>Foto Siswa (opsional):</label>
    <input type="file" name="foto" accept=".jpg, .jpeg, .png">

    <button type="submit">Simpan Data</button>
  </form>

</body>
</html>
