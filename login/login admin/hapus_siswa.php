<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: daftar_siswa.php");
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

if (isset($_GET['id'])) {
    $id_siswa = (int) $_GET['id'];

    // 1. Ambil wali_user_id dulu sebelum siswa dihapus
    $query = "SELECT wali_user_id FROM siswa WHERE id = $id_siswa";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $wali_user_id = $row['wali_user_id'];

        // 2. Hapus siswa dari tabel siswa
        $delete_siswa = mysqli_query($koneksi, "DELETE FROM siswa WHERE id = $id_siswa");

        // 3. Jika berhasil, hapus juga user walinya
        if ($delete_siswa) {
            mysqli_query($koneksi, "DELETE FROM users WHERE id = $wali_user_id");
            echo "<script>
                    alert('Data siswa dan akun walinya berhasil dihapus!');
                    window.location.href = 'daftar_kelas.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus data siswa: " . mysqli_error($koneksi) . "');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Data siswa tidak ditemukan!');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('ID siswa tidak valid!');
            window.history.back();
          </script>";
}
?>
