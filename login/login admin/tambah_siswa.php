<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: daftar_siswa.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Siswa Baru</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      margin: 0;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    form {
      background: white;
      max-width: 500px;
      margin: 30px auto;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #555;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      width: 100%;
      background: #4CAF50;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background: #45a049;
    }
    .back {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #007BFF;
      text-decoration: none;
    }
    .back:hover {
      text-decoration: underline;
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

    <button type="submit">Simpan Siswa</button>
  </form>

  <a href="javascript:history.back()" class="back">← Kembali</a>

</body>
</html>
