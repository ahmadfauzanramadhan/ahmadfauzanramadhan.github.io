<?php
@include 'koneksi.php'; // Menyertakan koneksi database

if (isset($_POST["submit"])) {
    // Mengambil dan men-sanitasi input
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $produk = mysqli_real_escape_string($conn, $_POST["produk"]);
    $jumlah = (int)$_POST["jumlah"]; // Pastikan jumlah adalah integer

    // Debugging: Tampilkan nilai input
    echo "<pre>";
    var_dump($nama, $email, $produk, $jumlah); // Debugging
    echo "</pre>";

    // Validasi input
    if (empty($nama) || empty($email) || empty($produk) || $jumlah <= 0) {
        echo "<script>alert('Mohon lengkapi semua field dengan benar!');</script>";
    } else {
        // Menangani file upload
        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $fileName = $_FILES["file"]["name"]; // Nama file
            $fileTmpPath = $_FILES["file"]["tmp_name"]; // Lokasi sementara file
            
            // Validasi ekstensi file (misalnya hanya menerima jpg, png, jpeg)
            $allowedExt = ['jpg', 'jpeg', 'png'];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array(strtolower($fileExt), $allowedExt)) {
                echo "<script>alert('Format file tidak valid. Hanya diperbolehkan JPG dan PNG.');</script>";
                exit;
            }
            
            // Mengatur zona waktu Asia/Makassar
            date_default_timezone_set('Asia/Makassar');
            // Membuat nama file baru dengan format yyyy-mm-dd hh.mm.ss.ekstensi
            $timestamp = date('Y-m-d H.i.s'); // Format waktu
            $newFileName = $timestamp . '.' . $fileExt; // Nama file baru
            $uploadDir = 'uploads/'; // Pastikan folder ini ada dan dapat ditulisi
            $destPath = $uploadDir . $newFileName;

            // Pindahkan file ke direktori yang diinginkan
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Siapkan query untuk menyimpan data ke database
                $query = "INSERT INTO pemesanan (nama, email, pilih_produk, jumlah, bukti_transfer) VALUES ('$nama', '$email', '$produk', '$jumlah', '$newFileName')";
                
                // Eksekusi query
                $result = mysqli_query($conn, $query);

                // Cek apakah query berhasil dieksekusi
                if ($result) {
                    echo "
                        <script>
                            alert('Pesanan Berhasil Ditambahkan!');
                            document.location.href = 'index.php';
                        </script>
                    ";
                } else {
                    echo "
                        <script>
                            alert('Pesanan Gagal Ditambahkan: " . mysqli_error($conn) . "');
                            document.location.href = 'index.php';
                        </script>
                    ";
                }
            } else {
                echo "<script>alert('File gagal diupload.');</script>";
            }
        } else {
            echo "<script>alert('Tidak ada file yang diupload atau terjadi kesalahan.');</script>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beliebers Merchandise Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="light-mode">
    <header>
        <div class="logo">Beliebers Shop</div>
        <nav id="navbar">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">Tentang Saya</a></li>
            </ul>
            <div class="hamburger-menu" onclick="toggleMenu()">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </nav>
    </header>

    <main id="home">
        <section class="hero">
            <h1>Welcome to Beliebers Merchandise Shop</h1>
            <p>Dapatkan merchandise resmi Justin Bieber di sini!</p>
            <button onclick="showPopup()">Lihat Promo</button>
        </section>
        
        <section class="products">
            <h2>Produk Terbaru</h2>
            <div class="product-grid">
                <div class="product">
                    <img src="media/9c2b3f07-2c3a-464a-818d-2a11d23ad5a3-removebg-preview.png" alt="T-shirt">
                    <h3>T-shirt Justin Bieber</h3>
                    <p>Harga: Rp150.000</p>
                </div>
                <div class="product">
                    <img src="media/il_570xN.5408273111_skf6-removebg-preview.png" alt="Hoodie">
                    <h3>Hoodie Justin Bieber</h3>
                    <p>Harga: Rp250.000</p>
                </div>
                <div class="product">
                    <img src="media/id-11134207-7qul7-ljex8jbyfzzha6_tn-removebg-preview.png" alt="Cap">
                    <h3>Topi Justin Bieber</h3>
                    <p>Harga: Rp100.000</p>
                </div>
            </div>
        </section>

        <section class="a">
            <h2 style="text-align: center;">Pemesanan Merchandise</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="text" id="nama" name="nama" placeholder="Nama" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <select id="produk" name="produk" required>
                    <option value="">Pilih Produk</option>
                    <option value="T-shirt Justin Bieber">T-shirt Justin Bieber</option>
                    <option value="Hoodie Justin Bieber">Hoodie Justin Bieber</option>
                    <option value="Topi Justin Bieber">Topi Justin Bieber</option>
                </select>
                <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah" min="1" required>
                <input type="file" id="file" name="file" accept="image/*"> <!-- Input file untuk mengunggah gambar -->
                <button type="submit" name="submit">Pesan</button>
            </form>


            <button onclick="location.href='listpesanan.php'" class="button">List Pesanan</button>

            <div id="order-result">
                <?php
                // Menampilkan pesan sukses atau error
                if (isset($_SESSION['success'])) {
                    echo "<p style='color: green;'>".$_SESSION['success']."</p>";
                    unset($_SESSION['success']);
                }
                if (isset($_SESSION['error'])) {
                    echo "<p style='color: red;'>".$_SESSION['error']."</p>";
                    unset($_SESSION['error']);
                }
                ?>
            </div>
        </section>
    </main>

    <section id="about">
        <h2>Tentang Saya</h2>
        <p>Nama: Ahmad Fauzan Ramadhan</p>
        <p>Saya baru berumur 19 tahun, masuk Informatika karena pertama senang ngoding hehe.</p>
    </section>

    <div id="popup-box" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h3 style="color: bisque;">Promo Spesial!</h3>
            <p style="color: bisque;">Beli 2 gratis 1 untuk semua merchandise hingga akhir bulan ini!</p>
        </div>
    </div>

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
