<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "sekolahsmk_db");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn = isset($_POST['nisn']) ? $_POST['nisn'] : '';
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';

    if (!empty($nisn) && !empty($nama)) {
        $sql = "SELECT * FROM siswa WHERE nisn='$nisn' AND nama='$nama'";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['nisn'] = $row['nisn'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = 'wali';
            header("Location: datasiswa_wali.php");
            exit;
        } else {
            echo "<p style='color:red; text-align:center;'>NISN atau Nama tidak cocok.</p>";
        }
    }
}
?>
<form action="login_wali.php" method="post">
  <label for="nisn">NISN:</label><br>
  <input type="text" id="nisn" name="nisn" required><br><br>

  <label for="nama">Nama Siswa:</label><br>
  <input type="text" id="nama" name="nama" required><br><br>

  <button type="submit">Login</button>
</form>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #b8e0d2, #d6f5e6);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    form {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        width: 300px;
    }
    label {
        font-weight: bold;
    }
    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button {
        width: 100%;
        padding: 10px;
        background: #6ab04c;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }
    button:hover {
        background: #57a143;
    }