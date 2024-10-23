<?php
// Sertakan file koneksi ke database
require "koneksi.php";

// Cek apakah ID ada dalam URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ambil ID dan pastikan itu adalah integer

    // Query untuk menghapus data dari tabel pemesanan
    $sql = "DELETE FROM pemesanan WHERE id_pemesanan = $id";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil dihapus, tampilkan pesan sukses dan redirect
        echo "
            <script>
                alert('Data berhasil dihapus!');
                window.location.href = 'listpesanan.php';
            </script>
        ";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "
            <script>
                alert('Error: " . $conn->error . "');
                window.location.href = 'listpesanan.php';
            </script>
        ";
    }
} else {
    // Jika ID tidak ada, redirect ke halaman daftar pemesanan
    header("Location: listpesanan.php");
}

// Tutup koneksi
$conn->close();
?>
