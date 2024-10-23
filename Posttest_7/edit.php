<?php
// Sertakan file koneksi ke database
require "koneksi.php";

// Cek apakah ID ada dalam URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ambil ID dan pastikan itu adalah integer

    // Query untuk mengambil data dari tabel pemesanan berdasarkan ID
    $sql = "SELECT * FROM pemesanan WHERE id_pemesanan = $id";
    $result = $conn->query($sql);

    // Cek apakah ada hasil
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Ambil data pemesanan
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='listpesanan.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='listpesanan.php';</script>";
    exit();
}

// Proses pembaruan data
if (isset($_POST["update"])) {
    // Ambil dan sanitasi input
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $produk = mysqli_real_escape_string($conn, $_POST["produk"]);
    $jumlah = (int)$_POST["jumlah"]; // Pastikan jumlah adalah integer

    // Validasi input
    if (empty($nama) || empty($email) || empty($produk) || $jumlah <= 0) {
        echo "<script>alert('Mohon lengkapi semua field dengan benar!');</script>";
    } else {
        // Proses upload file gambar jika ada
        $buktiTransfer = $_FILES['bukti_transfer']['name']; // Ambil nama file
        $uploadDir = 'uploads/'; // Folder untuk menyimpan file

        if (!empty($buktiTransfer)) {
            // Mengatur zona waktu Asia/Makassar
            date_default_timezone_set('Asia/Makassar');
            // Membuat nama file baru dengan format yyyy-mm-dd_hh.mm.ss.ekstensi
            $date = date('Y-m-d'); // Format tanggal
            $time = date('H.i.s'); // Format waktu
            $ext = pathinfo($buktiTransfer, PATHINFO_EXTENSION);
            $newFileName = $date . ' ' . $time . '.' . $ext; // Nama file baru
            
            // Path lengkap untuk file yang akan diupload
            $uploadFile = $uploadDir . $newFileName; // Gabungkan dengan direktori upload

            // Validasi ukuran file (maksimal 18MB)
            $maxFileSize = 18 * 1024 * 1024; // 18MB dalam bytes
            if ($_FILES['bukti_transfer']['size'] > $maxFileSize) {
                echo "<script>alert('Ukuran file terlalu besar! Maksimal 18MB.');</script>";
                exit();
            }

            // Validasi ekstensi file
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($ext), $validExtensions)) {
                // Hapus file gambar lama jika ada
                if (!empty($row['bukti_transfer'])) {
                    @unlink($uploadDir . $row['bukti_transfer']); // Hapus file lama
                }

                // Pindahkan file ke folder upload
                if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $uploadFile)) {
                    // Query untuk memperbarui data pemesanan, termasuk file
                    $updateQuery = "UPDATE pemesanan SET 
                        nama='$nama', 
                        email='$email', 
                        pilih_produk='$produk', 
                        jumlah=$jumlah, 
                        bukti_transfer='$newFileName' 
                        WHERE id_pemesanan=$id"; // Simpan hanya nama file
                } else {
                    echo "<script>alert('Gagal mengupload file!');</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Ekstensi file tidak valid! Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.');</script>";
                exit();
            }
        } else {
            // Jika tidak ada file baru, lakukan update tanpa bukti transfer
            $updateQuery = "UPDATE pemesanan SET 
                nama='$nama', 
                email='$email', 
                pilih_produk='$produk', 
                jumlah=$jumlah 
                WHERE id_pemesanan=$id";
        }
        
        // Eksekusi query
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location.href='listpesanan.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
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
    <title>Edit Pemesanan</title>
</head>
<body>
    <h2>Edit Pemesanan</h2>
    <form method="POST" action="" enctype="multipart/form-data"> <!-- Tambahkan enctype -->
        <input type="text" id="nama" name="nama" placeholder="Nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
        <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
        <select id="produk" name="produk" required>
            <option value="">Pilih Produk</option>
            <option value="T-shirt Justin Bieber" <?php echo ($row['pilih_produk'] == 'T-shirt Justin Bieber') ? 'selected' : ''; ?>>T-shirt Justin Bieber</option>
            <option value="Hoodie Justin Bieber" <?php echo ($row['pilih_produk'] == 'Hoodie Justin Bieber') ? 'selected' : ''; ?>>Hoodie Justin Bieber</option>
            <option value="Topi Justin Bieber" <?php echo ($row['pilih_produk'] == 'Topi Justin Bieber') ? 'selected' : ''; ?>>Topi Justin Bieber</option>
        </select>
        <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah" min="1" value="<?php echo htmlspecialchars($row['jumlah']); ?>" required>
        <input type="file" id="bukti_transfer" name="bukti_transfer"> <!-- Input file baru -->

        <!-- Menampilkan bukti transfer yang ada -->
        <?php if (!empty($row['bukti_transfer'])): ?>
            <div>
                <p>Bukti Transfer Sebelumnya:</p>
                <img src="uploads/<?php echo htmlspecialchars($row['bukti_transfer']); ?>" alt="Bukti Transfer" style="width: 100px; height: auto;">
            </div>
        <?php endif; ?>

        <button type="submit" name="update">Perbarui</button>
    </form>
    <button onclick="location.href='listpesanan.php'">Kembali ke Daftar Pemesanan</button>
</body>
</html>
