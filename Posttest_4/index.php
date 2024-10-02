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

        <section>
            <h2 style="text-align: center;">Pemesanan Merchandise</h2>
            <form id="order-form" method="POST" action="">
                <input type="text" id="nama" name="nama" placeholder="Nama" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <select id="produk" name="produk" required>
                    <option value="">Pilih Produk</option>
                    <option value="T-shirt">T-shirt</option>
                    <option value="Hoodie">Hoodie</option>
                    <option value="Topi">Topi</option>
                </select>
                <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah" min="1" required>
                <button type="submit">Pesan</button>
            </form>

            <div id="order-result">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nama = htmlspecialchars($_POST['nama']);
                    $email = htmlspecialchars($_POST['email']);
                    $produk = htmlspecialchars($_POST['produk']);
                    $jumlah = htmlspecialchars($_POST['jumlah']);
                    
                    echo "<p>Terima kasih, $nama! Anda telah memesan $jumlah $produk. Kami akan mengirimkan konfirmasi ke $email.</p>";
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
            <p style="color: bisque;">Beli 2     gratis 1 untuk semua merchandise hingga akhir bulan ini!</p>
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
