<?php
header('Content-Type: application/json');
require_once 'config.php';

// Statistik jumlah perkawinan per kategori
if (isset($_GET['stat']) && $_GET['stat'] == 'perkawinan') {
    $stmt = $pdo->query("SELECT kategori, COUNT(*) as total FROM perkawinan GROUP BY kategori");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

// Statistik jumlah keluarga per wilayah adat
if (isset($_GET['stat']) && $_GET['stat'] == 'keluarga') {
    $stmt = $pdo->query("SELECT wilayah_adat.nama as wilayah, COUNT(*) as total
                        FROM keluarga
                        LEFT JOIN wilayah_adat ON keluarga.wilayah_adat_id = wilayah_adat.id
                        GROUP BY keluarga.wilayah_adat_id");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

// Statistik jumlah keluarga per suku
if (isset($_GET['stat']) && $_GET['stat'] == 'keluarga_suku') {
    $stmt = $pdo->query("SELECT suku.nama as suku, COUNT(*) as total
                        FROM keluarga
                        LEFT JOIN suku ON keluarga.suku_id = suku.id
                        GROUP BY keluarga.suku_id");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

// Default
http_response_code(400);
echo json_encode(['error'=>'Parameter stat tidak dikenali']);
exit;
?>