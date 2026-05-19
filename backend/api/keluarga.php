<?php
header('Content-Type: application/json');
require_once 'config.php';

// Ambil seluruh keluarga
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT keluarga.*, wilayah_adat.nama as wilayah, suku.nama as suku FROM keluarga LEFT JOIN wilayah_adat ON keluarga.wilayah_adat_id = wilayah_adat.id LEFT JOIN suku ON keluarga.suku_id = suku.id ORDER BY keluarga.nama_kepala_keluarga");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

// Tambah keluarga
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $nik = $input['nik_kepala_keluarga'] ?? '';
    $nama = $input['nama_kepala_keluarga'] ?? '';
    $alamat = $input['alamat'] ?? '';
    $wilayah_id = $input['wilayah_adat_id'] ?? 0;
    $suku_id = $input['suku_id'] ?? 0;
    if ($nik && $nama && $wilayah_id && $suku_id) {
        $stmt = $pdo->prepare("INSERT INTO keluarga (nik_kepala_keluarga, nama_kepala_keluarga, alamat, wilayah_adat_id, suku_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nik, $nama, $alamat, $wilayah_id, $suku_id]);
        echo json_encode(['message' => 'Keluarga berhasil ditambah']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Data tidak lengkap']);
    }
    exit;
}
