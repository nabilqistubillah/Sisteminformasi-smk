<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: tambah_siswa.php");
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $sakit = (int) $_POST['sakit'];
    $izin = (int) $_POST['izin'];
    $alpha = (int) $_POST['alpha'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    // Proses upload foto jika ada
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $target_dir = "../uploads/foto_siswa/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = uniqid("siswa_") . "." . strtolower($ext);
        $target_file = $target_dir . $foto;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            echo "<script>alert('Gagal mengunggah foto.'); window.history.back();</script>";
            exit;
        }
    }

    // Simpan ke database
    $sql = "INSERT INTO siswa (nama, nisn, kelas, sakit, izin, alpha, keterangan, foto) 
            VALUES ('$nama', '$nisn', '$kelas', '$sakit', '$izin', '$alpha', '$keterangan', " . 
            ($foto ? "'$foto'" : "NULL") . ")";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
                alert('Data siswa berhasil ditambahkan!');
                window.location.href = 'daftar_siswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan siswa: " . mysqli_error($koneksi) . "');
                window.history.back();
              </script>";
    }
}
?>
