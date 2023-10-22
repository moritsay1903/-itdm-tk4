<?php
// Sambungkan ke database
$koneksi = new mysqli("localhost", "username", "password", "nama_database");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Ambil data penjualan, biaya, harga beli, dan harga jual barang dari database
$sql = "SELECT NamaBarang, Penjualan, BiayaProduksi, HargaBeli FROM daftar_barang";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    // Inisialisasi variabel untuk total pendapatan, total biaya, dan total laba
    $totalPendapatan = 0;
    $totalBiaya = 0;

    // Tampilkan tabel header
    echo "<table border='1'>";
    echo "<tr><th>Nama Barang</th><th>Pendapatan</th><th>Biaya</th><th>Laba</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $pendapatan = $row["Penjualan"];
        $biaya = $row["BiayaProduksi"];
        $laba = $pendapatan - $biaya;

        // Tampilkan data dalam tabel
        echo "<tr><td>" . $row["NamaBarang"] . "</td><td>" . $pendapatan . "</td><td>" . $biaya . "</td><td>" . $laba . "</td></tr>";

        // Akumulasi total pendapatan dan total biaya
        $totalPendapatan += $pendapatan;
        $totalBiaya += $biaya;
    }

    // Hitung total laba
    $totalLaba = $totalPendapatan - $totalBiaya;

    // Tampilkan total laba
    echo "<tr><td>Total</td><td>" . $totalPendapatan . "</td><td>" . $totalBiaya . "</td><td>" . $totalLaba . "</td></tr>";
    
    echo "</table>";
} else {
    echo "Tidak ada data barang yang ditemukan.";
}

$koneksi->close();
?>
