<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: edit_siswa.php");
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $kelas = $_POST['kelas'];
    $sakit = $_POST['sakit'];
    $izin = $_POST['izin'];
    $alpha = $_POST['alpha'];
    $keterangan = $_POST['keterangan'];

    // Ambil data lama untuk mengetahui nama file foto sebelumnya
    $queryLama = $koneksi->prepare("SELECT foto FROM siswa WHERE id=?");
    $queryLama->bind_param("i", $id);
    $queryLama->execute();
    $result = $queryLama->get_result();
    $dataLama = $result->fetch_assoc();
    $fotoLama = $dataLama['foto'] ?? null;

    $fotoBaru = $fotoLama;

    // Jika ada foto baru diupload
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "../uploads/foto_siswa/";
        $fileName = time() . "_" . basename($_FILES["foto"]["name"]);
        $targetFile = $targetDir . $fileName;

        // Validasi format file
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png"];

        if (in_array($fileType, $allowed)) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
                // Hapus foto lama jika ada dan bukan default
                if ($fotoLama && $fotoLama != "default.png" && file_exists($targetDir . $fotoLama)) {
                    unlink($targetDir . $fotoLama);
                }
                $fotoBaru = $fileName;
            }
        }
    }

    // Update data siswa
    $stmt = $koneksi->prepare("UPDATE siswa SET nama=?, nisn=?, kelas=?, sakit=?, izin=?, alpha=?, keterangan=?, foto=? WHERE id=?");
    $stmt->bind_param("sssiiissi", $nama, $nisn, $kelas, $sakit, $izin, $alpha, $keterangan, $fotoBaru, $id);

    if ($stmt->execute()) {
        header("Location: daftar_siswa.php?kelas=" . urlencode($kelas));
        exit;
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }
} else {
    echo "Akses tidak valid.";
}
?>
