<?php
header('Content-Type: application/json');
require_once 'config.php';

// Ambil semua suku
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $wilayah = isset($_GET['wilayah_adat_id']) ? intval($_GET['wilayah_adat_id']) : 0;
    if ($wilayah > 0) {
        $stmt = $pdo->prepare("SELECT suku.*, wilayah_adat.nama as wilayah_adat FROM suku LEFT JOIN wilayah_adat ON suku.wilayah_adat_id = wilayah_adat.id WHERE wilayah_adat_id = ? ORDER BY suku.nama");
        $stmt->execute([$wilayah]);
    } else {
        $stmt = $pdo->query("SELECT suku.*, wilayah_adat.nama as wilayah_adat FROM suku LEFT JOIN wilayah_adat ON suku.wilayah_adat_id = wilayah_adat.id ORDER BY suku.nama");
    }
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

// Tambah suku baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $nama = $input['nama'] ?? '';
    $wilayah_adat_id = $input['wilayah_adat_id'] ?? 0;
    if ($nama && $wilayah_adat_id) {
        $stmt = $pdo->prepare("INSERT INTO suku (nama, wilayah_adat_id) VALUES (?, ?)");
        $stmt->execute([$nama, $wilayah_adat_id]);
        echo json_encode(['message' => 'Suku berhasil ditambah']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Data kurang lengkap']);
    }
    exit;
}
