<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "toko_laptop");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data untuk ditampilkan di tabel
$result = $conn->query("SELECT * FROM stok_laptop");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok Laptop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Cek & Kurangi Stok Laptop</h2>
        
        <?php if (isset($_GET['status'])): ?>
            <div class="alert <?php echo $_GET['status'] == 'success' ? 'alert-success' : 'alert-danger'; ?>">
                <?php 
                    if ($_GET['status'] == 'success') echo "Stok berhasil diperbarui!";
                    if ($_GET['status'] == 'soldout') echo "Maaf, barang tersebut sudah Sold Out!";
                    if ($_GET['status'] == 'notfound') echo "Data laptop tidak ditemukan!";
                    if ($_GET['status'] == 'empty') echo "Semua kolom harus diisi!";
                ?>
            </div>
        <?php endif; ?>

        <!-- Form Input -->
<form action="proses.php" method="POST" class="form-stok">
    <div class="form-group">
        <label>Nama Brand</label>
        <input type="text" name="brand" placeholder="Contoh: Asus, Lenovo" required>
    </div>
    <div class="form-group">
        <label>Seri Laptop</label>
        <input type="text" name="seri" placeholder="Contoh: ROG, Legion" required>
    </div>
    <div class="form-group">
        <label>Model</label>
        <input type="text" name="model" placeholder="Contoh: G14, Pro 5" required>
    </div>
    
    <!-- Tombol Aksi Berdampingan -->
    <div class="btn-container grid-buttons">
        <button type="submit" name="action" value="kurang" class="btn-submit btn-kurang">
            🔻 Kurangi 1 Stok (Jual)
        </button>
        <button type="submit" name="action" value="tambah" class="btn-submit btn-tambah">
            🔺 Tambah 1 Stok (Masuk)
        </button>
    </div>
</form>

        <hr>

        <h2>Daftar Sisa Stok Laptop</h2>
        <table>
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Seri</th>
                    <th>Model</th>
                    <th>Status Stok</th>
                </tr>
            </thead>
            <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <?php 
                // Logika penentuan warna baris dan badge berdasarkan jumlah stok
                $row_class = "";
                if ($row['stok'] == 0) {
                    $row_class = "row-soldout";
                    $badge = '<span class="badge badge-soldout">Sold Out</span>';
                } elseif ($row['stok'] <= 2) {
                    $badge = '<span class="badge badge-warning">Menipis ('.$row['stok'].')</span>';
                } else {
                    $badge = '<span class="badge badge-available">Tersedia ('.$row['stok'].')</span>';
                }
            ?>
            <tr class="<?php echo $row_class; ?>">
                <td><strong><?php echo htmlspecialchars($row['brand']); ?></strong></td>
                <td><?php echo htmlspecialchars($row['seri']); ?></td>
                <td><?php echo htmlspecialchars($row['model']); ?></td>
                <td><?php echo $badge; ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align: center; color: #94a3b8;">Belum ada data laptop di database.</td>
        </tr>
    <?php endif; ?>
</tbody>
        </table>
    </div>

</body>
</html>
<?php $conn->close(); ?>