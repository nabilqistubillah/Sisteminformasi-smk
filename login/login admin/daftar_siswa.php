<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'guru')) {
    header("Location: daftar_kelas.php");
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

// mengambil parameter kelas
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$sql = "SELECT * FROM siswa WHERE kelas='$kelas'";

// jika ada pencarian
if (!empty($cari)) {
    $sql .= " AND (nama LIKE '%$cari%' OR nisn LIKE '%$cari%')";
}

$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Siswa <?= htmlspecialchars($kelas) ?></title>
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

    /* Search Bar & Tombol Tambah */
    .toolbar {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 15px;
      margin-bottom: 25px;
    }

    .toolbar input[type="text"] {
      padding: 10px 15px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      outline: none;
    }

    .toolbar button,
    .toolbar a {
      padding: 10px 16px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.2s;
    }

    .toolbar button {
      background: #b0bfff;
    }
    .toolbar button:hover {
      background: #90a7ff;
    }

    .toolbar a {
      text-decoration: none;
      background: #6fcf97;
      color: white;
    }
    .toolbar a:hover {
      background: #5dbf86;
    }

    /* Kartu siswa */
    .siswa-container {
      display: grid;
      gap: 20px;
      max-width: 1000px;
      margin: 0 auto;
    }
    .siswa-card {
      background: white;
      padding: 15px 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: transform 0.2s;
    }
    .siswa-card:hover {
      transform: scale(1.02);
    }
    .siswa-info {
      display: flex;
      align-items: center;
      gap: 15px;
      flex: 1;
    }
    .siswa-info img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
    }
    .siswa-text h3 {
      margin: 0;
      font-size: 18px;
    }
    .siswa-text p {
      margin: 3px 0;
      color: #333;
      font-size: 14px;
    }
    .siswa-card a {
      text-decoration: none;
      color: #000;
      background: #b0bfff;
      padding: 8px 14px;
      border-radius: 10px;
      font-weight: bold;
      transition: background 0.2s;
      flex-shrink: 0;
      margin-left: 10px;
    }
    .siswa-card a:hover {
      background: #90a7ff;
    }
  </style>
</head>
<body>

<button style="background: #b0bfff; "><a style="text-decoration: none; background: #6fcf97; color: white;" href="daftar_kelas.php?kelas=<?= urlencode($kelas) ?>"> < Kembali</a></button>
  <h2>Daftar Siswa - <?= htmlspecialchars($kelas) ?></h2>

  <!-- Search bar dan tombol tambah -->
  <form method="get" class="toolbar">
    <input type="hidden" name="kelas" value="<?= htmlspecialchars($kelas) ?>">
    <input type="text" name="cari" placeholder="Cari nama atau NISN..." value="<?= htmlspecialchars($cari) ?>">
    <button type="submit">Cari</button>
    <?php if ($_SESSION['role'] == 'admin'): ?>
      <a href="tambah_siswa.php?kelas=<?= urlencode($kelas) ?>">+ Tambah Siswa</a>
    <?php endif; ?>
  </form>

  <div class="siswa-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <?php $foto = !empty($row['foto']) ? "../uploads/foto_siswa/".$row['foto'] : "../uploads/foto_siswa/default.png"; ?>
            <div class="siswa-card">
              <div class="siswa-info">
                <img src="<?= $foto ?>" alt="Foto <?= $row['nama'] ?>">
                <div class="siswa-text">
                  <h3><?= $row['nama'] ?></h3>
                  <p>NISN: <?= $row['nisn'] ?></p>
                  <p>Kelas: <?= $row['kelas'] ?></p>
                </div>
              </div>
              <a href="datasiswa_admin.php?id=<?= $row['id'] ?>">Lihat Detail</a>
              <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="edit_siswa.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="hapus_siswa.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data siswa ini?');" style="background: #ff7f7f;">Delete</a>
              <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">Tidak ada data siswa di kelas ini.</p>
    <?php endif; ?>
  </div>

</body>
</html>
