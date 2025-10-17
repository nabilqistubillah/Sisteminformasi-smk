<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'guru')) {
    header("Location: daftar_siswa.php");
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

// Ambil data siswa berdasarkan ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$sql = "SELECT * FROM siswa WHERE id='$id'";
$result = $koneksi->query($sql);
$siswa = $result->fetch_assoc();

// Jika data tidak ditemukan
if (!$siswa) {
    echo "<p style='text-align:center; margin-top:20px;'>Data siswa tidak ditemukan.</p>";
    exit;
}

// Foto siswa (gunakan default jika kosong)
$foto = !empty($siswa['foto']) ? "../uploads/foto_siswa/" . $siswa['foto'] : "../uploads/foto_siswa/default.png";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Siswa - <?= htmlspecialchars($siswa['nama']) ?></title>
    
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #a8c0ff, #8fb3ff);
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar kiri */
        .sidebar {
            width: 300px;
            background: #f5f7fa;
            padding: 30px 20px;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }

        .profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .profile h3 {
            margin: 5px 0;
            font-size: 18px;
        }

        .profile p {
            font-size: 14px;
            color: #555;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu a {
            background: white;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            color: #333;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .menu a:hover {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        /* Konten utama */
        .content {
            flex: 1;
            padding: 40px;
        }

        .section {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            margin-top: 0;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            color: #007bff;
        }

        .jadwal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 15px;
            text-align: center;
        }

        .jadwal-grid div {
            background: #f0f2f5;
            padding: 8px;
            border-radius: 6px;
            font-size: 14px;
        }

        .jadwal-grid li {
            list-style: none;
            margin: 4px 0;
        }

        .grafik {
            height: 250px;
            background: linear-gradient(135deg, #e3eeff, #cfd8ff);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Sidebar kiri -->
        <div class="sidebar">
            <div class="profile">
                <img src="<?= $foto ?>" alt="Foto <?= htmlspecialchars($siswa['nama']) ?>">
                <h3><?= htmlspecialchars($siswa['nama']) ?></h3>
                <p>NISN: <?= htmlspecialchars($siswa['nisn']) ?></p>
                <p>Kelas: <?= htmlspecialchars($siswa['kelas']) ?></p>
            </div>

            <div class="menu">
                <a href="datasiswabiodata_admin.php?id=<?= $id ?>">Biodata</a>
                <a href="datasiswaabsensi_admin.php?id=<?= $id ?>">Absensi</a>
                <a href="datasiswanilai_admin.php?id=<?= $id ?>">Nilai</a>
                <a href="datasiswacatatan_admin.php?id=<?= $id ?>">Catatan Perilaku</a>
            </div>
        </div>

        <!-- Konten utama -->
        <div class="content">
            <div class="section">
                <h2>Jadwal Pelajaran</h2>
                <div class="jadwal-grid">
                    <div>Senin
                        <li>mtk</li>
                        <li>mtk</li>
                        <li>mtk</li>
                    </div>
                    <div>Selasa
                        <li>mtk</li>
                        <li>mtk</li>
                        <li>mtk</li>
                    </div>
                    <div>Rabu
                        <li>mtk</li>
                        <li>mtk</li>
                        <li>mtk</li>
                    </div>
                    <div>Kamis
                        <li>mtk</li>
                        <li>mtk</li>
                        <li>mtk</li>
                    </div>
                    <div>Sabtu
                        <li>mtk</li>
                        <li>mtk</li>
                        <li>mtk</li>
                    </div>
                    <div>Ahad
                        <li>mtk</li>
                        <li>mtk</li>
                        <li>mtk</li>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Perkembangan Belajar</h2>
                <div class="grafik">
                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-success" style="width: 25%"></div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-info" style="width: 50%"></div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-warning" style="width: 75%"></div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-danger" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>