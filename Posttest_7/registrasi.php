<?php
// Sertakan file koneksi ke database
require "koneksi.php";

// Inisialisasi variabel untuk pesan error dan sukses
$error = "";
$success = "";

// Cek jika form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form registrasi
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi form
    if (empty($nama) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Semua kolom harus diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Silakan masukkan email yang valid.";
    } elseif ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak sesuai.";
    } else {
        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menyimpan data ke dalam database
        $sql = "INSERT INTO users (nama, email, password) VALUES (?, ?, ?)";

        // Siapkan statement untuk mencegah SQL Injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nama, $email, $hashed_password);

        // Eksekusi query
        if ($stmt->execute()) {
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
        }

        // Tutup statement
        $stmt->close();
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<header>
    <h1>Registrasi Pengguna</h1>
</header>

<main>
    <div id="order-form-container">
        <form id="order-form" method="POST" action="registrasi.php">
            <h2>Form Registrasi</h2>

            <!-- Tampilkan pesan error atau sukses -->
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php endif; ?>

            <!-- Input Nama -->
            <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required>

            <!-- Input Email -->
            <input type="email" id="email" name="email" placeholder="Email" required>

            <!-- Input Password -->
            <input type="password" id="password" name="password" placeholder="Password" required>

            <!-- Input Konfirmasi Password -->
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>

            <!-- Tombol Submit -->
            <button type="submit">Daftar</button>
        </form>

        <div class="back-button-container">
            <button onclick="location.href='index.php'" class="button">Kembali ke Halaman Utama</button>
        </div>
    </div>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Nama Perusahaan. Semua hak dilindungi.</p>
</footer>

</body>
</html>
