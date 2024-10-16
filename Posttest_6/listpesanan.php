<?php
// Sertakan file koneksi ke database
require "koneksi.php";

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel pemesanan
$sql = "SELECT * FROM pemesanan";
$result = $conn->query($sql);

// Mulai tampilan HTML
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemesanan</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<header>
    <h1>Daftar Pemesanan</h1>
</header>

<main>
    <div class="table-container">
        <?php
        if ($result) {
            echo "<table>
                    <tr>
                        <th>ID Pemesanan</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pilih Produk</th>
                        <th>Jumlah</th>
                        <th>Bukti Transfer</th>
                        <th>Aksi</th>
                    </tr>";

            // Tampilkan setiap baris data
            while ($row = $result->fetch_assoc()) {
                // Ambil nama file bukti transfer dan sanitasi
                $buktiTransferFileName = htmlspecialchars($row["bukti_transfer"]);

                // Path untuk file gambar
                $buktiTransferPath = "uploads/" . $buktiTransferFileName; // Pastikan ini adalah path yang benar

                // Cek apakah bukti transfer ada dan bukan kosong
                if (!empty($buktiTransferFileName) && file_exists($buktiTransferPath)) {
                    // Tambahkan timestamp untuk mencegah cache browser
                    $imgSrc = $buktiTransferPath . '?' . time();
                    $imgTag = "<img src='$imgSrc' alt='Bukti Transfer' style='width: 100px; height: auto;'>";
                } else {
                    $imgTag = "<p style='color: red;'>Gambar tidak ditemukan</p>";
                }

                echo "<tr>
                        <td>" . htmlspecialchars($row["id_pemesanan"]) . "</td>
                        <td>" . htmlspecialchars($row["nama"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["pilih_produk"]) . "</td>
                        <td>" . htmlspecialchars($row["jumlah"]) . "</td>
                        <td>$imgTag</td>
                        <td>
                            <button onclick=\"location.href='edit.php?id=" . $row["id_pemesanan"] . "'\" class='button'>Edit</button>
                            <button onclick=\"if(confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')) { location.href='delete.php?id=" . $row["id_pemesanan"] . "'; }\" class='button'>Hapus</button>
                        </td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Query gagal: " . $conn->error . "</p>";
        }

        $conn->close();
        ?>
    </div>

    <div class="back-button-container">
        <button onclick="location.href='index.php'" class="button">Kembali ke Halaman Utama</button>
    </div>

</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Nama Perusahaan. Semua hak dilindungi.</p>
</footer>

</body>
</html>
