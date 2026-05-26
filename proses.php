<?php
if (isset($_POST['brand'], $_POST['seri'], $_POST['model'], $_POST['action'])) {
    
    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "toko_laptop");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form dan bersihkan
    $brand  = trim($_POST['brand']);
    $seri   = trim($_POST['seri']);
    $model  = trim($_POST['model']);
    $action = $_POST['action']; // Berisi 'kurang' atau 'tambah'

    if (empty($brand) || empty($seri) || empty($model)) {
        header("Location: index.php?status=empty");
        exit();
    }

    // 1. Cek apakah laptop tersebut sudah terdaftar di database
    $stmt = $conn->prepare("SELECT id, stok FROM stok_laptop WHERE brand = ? AND seri = ? AND model = ?");
    $stmt->bind_param("sss", $brand, $seri, $model);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($action === 'tambah') {
        // --- LOGIKA STOK MASUK ---
        if ($result->num_rows > 0) {
            // Jika laptop sudah ada, tambahkan stoknya +1
            $update_stmt = $conn->prepare("UPDATE stok_laptop SET stok = stok + 1 WHERE brand = ? AND seri = ? AND model = ?");
            $update_stmt->bind_param("sss", $brand, $seri, $model);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // Jika laptop BELUM ADA, otomatis daftarkan baru dengan stok awal 1
            $insert_stmt = $conn->prepare("INSERT INTO stok_laptop (brand, seri, model, stok) VALUES (?, ?, ?, 1)");
            $insert_stmt->bind_param("sss", $brand, $seri, $model);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
        header("Location: index.php?status=success");
        exit();

    } elseif ($action === 'kurang') {
        // --- LOGIKA STOK KELUAR (JUAL) ---
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stok_sekarang = $row['stok'];

            if ($stok_sekarang > 0) {
                // Kurangi stok jika barang tersedia
                $update_stmt = $conn->prepare("UPDATE stok_laptop SET stok = stok - 1 WHERE brand = ? AND seri = ? AND model = ? AND stok > 0");
                $update_stmt->bind_param("sss", $brand, $seri, $model);
                $update_stmt->execute();

                if ($update_stmt->affected_rows > 0) {
                    header("Location: index.php?status=success");
                } else {
                    header("Location: index.php?status=soldout");
                }
                $update_stmt->close();
            } else {
                header("Location: index.php?status=soldout");
            }
        } else {
            // Jika sales ingin menjual barang yang namanya tidak terdaftar
            header("Location: index.php?status=notfound");
        }
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
}
?>