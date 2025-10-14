<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: daftar_siswa.php");
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

// pastikan ada id siswa
if (!isset($_GET['id'])) {
    echo "ID siswa tidak ditemukan.";
    exit;
}

$id = $_GET['id'];

// ambil data siswa berdasarkan id
$sql = "SELECT * FROM siswa WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();

if (!$siswa) {
    echo "Data siswa tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Siswa</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      margin: 0;
      padding: 30px;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    form {
      max-width: 600px;
      background: white;
      padding: 20px 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin: 0 auto;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-sizing: border-box;
    }
    img {
      display: block;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      margin-top: 10px;
    }
    button {
      margin-top: 20px;
      padding: 10px 18px;
      background: #6fcf97;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.2s;
    }
    button:hover {
      background: #5dbf86;
    }
    .back-link {
      display: inline-block;
      margin-top: 15px;
      text-decoration: none;
      color: #555;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <h2>Edit Data Siswa</h2>

  <form action="proses_edit_siswa.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $siswa['id'] ?>">

    <label>Nama Siswa</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required>

    <label>NISN</label>
    <input type="text" name="nisn" value="<?= htmlspecialchars($siswa['nisn']) ?>" required>

    <label>Kelas</label>
    <input type="text" name="kelas" value="<?= htmlspecialchars($siswa['kelas']) ?>" required>

    <label>Sakit</label>
    <input type="number" name="sakit" value="<?= htmlspecialchars($siswa['sakit']) ?>" min="0">

    <label>Izin</label>
    <input type="number" name="izin" value="<?= htmlspecialchars($siswa['izin']) ?>" min="0">

    <label>Alfa</label>
    <input type="number" name="alfa" value="<?= htmlspecialchars($siswa['alpha']) ?>" min="0">

    <label>Keterangan</label>
    <textarea name="keterangan"><?= htmlspecialchars($siswa['keterangan']) ?></textarea>

    <label>Foto Siswa</label>
    <?php if (!empty($siswa['foto'])): ?>
        <img src="../uploads/foto_siswa/<?= htmlspecialchars($siswa['foto']) ?>" alt="Foto">
    <?php endif; ?>
    <input type="file" name="foto">

    <button type="submit">Simpan Perubahan</button>
  </form>

  <a href="javascript:history.back()" class="back-link">← Kembali</a>

</body>
</html>
