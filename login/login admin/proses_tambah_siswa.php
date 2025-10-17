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

    // Upload foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $target_dir = "../uploads/foto_siswa/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = uniqid("siswa_") . "." . strtolower($ext);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto);
    }

    // === 1. Tambahkan data wali baru ke tabel users ===
    $username_wali = "wali_" . preg_replace('/\s+/', '_', strtolower($nama));
    $password_wali = $nisn; // nanti wali login pakai NISN
    $role = "wali";

    $query_wali = "INSERT INTO users (username, password, role) VALUES ('$username_wali', '$password_wali', '$role')";
    $insert_wali = mysqli_query($koneksi, $query_wali);

    if (!$insert_wali) {
        echo "<script>alert('Gagal menambahkan wali: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
        exit;
    }

    // Ambil ID wali yang baru dibuat
    $wali_user_id = mysqli_insert_id($koneksi);

    // === 2. Tambahkan siswa dengan wali_user_id ===
    $sql = "INSERT INTO siswa (nama, nisn, kelas, sakit, izin, alpha, keterangan, foto, wali_user_id)
            VALUES ('$nama', '$nisn', '$kelas', '$sakit', '$izin', '$alpha', '$keterangan', " .
            ($foto ? "'$foto'" : "NULL") . ", '$wali_user_id')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data siswa & wali berhasil ditambahkan!'); window.location.href='daftar_kelas.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan siswa: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
    }
}
?>
