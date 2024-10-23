<?php
@include 'koneksi.php'; // Menyertakan koneksi database

session_start(); // Mulai sesi

if (isset($_POST['login'])) {
    // Mengambil dan men-sanitasi input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validasi input
    if (empty($email) || empty($password)) {
        echo "<script>alert('Mohon lengkapi semua field!');</script>";
    } else {
        // Cek apakah email ada di database
        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1"; // Ganti 'users' dengan nama tabel pengguna Anda
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verifikasi password (misalkan Anda menggunakan hash untuk password)
            if (password_verify($password, $user['password'])) {
                // Set session untuk login
                $_SESSION['user_id'] = $user['id']; // Ganti 'id' dengan kolom yang sesuai di tabel pengguna Anda
                $_SESSION['user_name'] = $user['nama']; // Ganti 'nama' dengan kolom yang sesuai di tabel pengguna Anda
                
                echo "<script>alert('Login berhasil!'); document.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Email atau password salah!');</script>";
            }
        } else {
            echo "<script>alert('Email tidak terdaftar!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Beliebers Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="light-mode">
    <header>
        <div class="logo">Beliebers Shop</div>
        <nav id="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#about">Tentang Saya</a></li>
                <li><a href="registrasi.php">Registrasi</a></li>
            </ul>
            <div class="hamburger-menu" onclick="toggleMenu()">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </nav>
    </header>

    <main>
        <div id="login-form-container">
            <form id="login-form" method="POST" action="">
                <h2>Login</h2>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Belum punya akun? <a href="registrasi.php">Daftar di sini</a></p>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Beliebers Shop | Semua hak dilindungi</p>
        <div class="social-media">
            <a href="#">Instagram</a> | <a href="#">Twitter</a> | <a href="#">Facebook</a>
        </div>
    </footer>

    <button class="dark-mode-toggle" onclick="toggleDarkMode()">Ubah ke Dark Mode</button>

    <script src="scripts.js"></script>
</body>
</html>
