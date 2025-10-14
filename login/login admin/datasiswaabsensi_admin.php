<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'guru')) {
    header("Location: datasaiswa_admin.php");
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// ambil ID siswa dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<p style='text-align:center; margin-top:20px;'>ID siswa tidak valid.</p>";
    exit;
}

// ambil data siswa (termasuk kolom absensi)
$stmt = $koneksi->prepare("SELECT * FROM siswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$siswa = $res->fetch_assoc();
$stmt->close();

if (!$siswa) {
    echo "<p style='text-align:center; margin-top:20px;'>Data siswa tidak ditemukan.</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Absensi - <?= htmlspecialchars($siswa['nama']) ?></title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #a8c0ff, #8fb3ff);
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 900px;
      background: white;
      margin: 30px auto;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      padding: 30px;
    }
    .header {
      display: flex;
      align-items: center;
      gap: 20px;
      border-bottom: 2px solid #007bff;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .header img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
    }
    h2 {
      margin: 0;
      color: #007bff;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background: #007bff;
      color: white;
    }
    tr:nth-child(even) {
      background: #f5f7fa;
    }
    .back-btn {
      display: inline-block;
      margin-top: 20px;
      background: #007bff;
      color: white;
      text-decoration: none;
      padding: 8px 15px;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="<?= !empty($siswa['foto']) ? '../uploads/foto_siswa/'.htmlspecialchars($siswa['foto']) : '../uploads/foto_siswa/default.png' ?>" alt="Foto <?= htmlspecialchars($siswa['nama']) ?>">
      <div>
        <h2>Absensi - <?= htmlspecialchars($siswa['nama']) ?></h2>
        <p><strong>NISN:</strong> <?= htmlspecialchars($siswa['nisn']) ?></p>
        <p><strong>Kelas:</strong> <?= htmlspecialchars($siswa['kelas']) ?></p>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Sakit</th>
          <th>Izin</th>
          <th>Alfa</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= htmlspecialchars($siswa['sakit']) ?></td>
          <td><?= htmlspecialchars($siswa['izin']) ?></td>
          <td><?= htmlspecialchars($siswa['alpha']) ?></td>
          <td><?= htmlspecialchars($siswa['keterangan']) ?></td>
        </tr>
      </tbody>
    </table>

    <a href="datasiswa_admin.php?id=<?= $id ?>" class="back-btn">← Kembali ke Data Siswa</a>
  </div>
</body>
</html>
