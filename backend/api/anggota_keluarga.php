<?php
header('Content-Type: application/json');
require_once 'config.php';

// Ambil seluruh anggota keluarga
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $keluarga_id = isset($_GET['keluarga_id']) ? intval($_GET['keluarga_id']) : 0;
    if ($keluarga_id > 0) {
        $stmt = $pdo->prepare("SELECT anggota_keluarga.*, suku.nama as suku, wilayah_adat.nama as wilayah FROM anggota_keluarga LEFT JOIN suku ON anggota_keluarga.suku_id = suku.id LEFT JOIN wilayah_adat ON anggota_keluarga.wilayah_adat_id = wilayah_adat.id WHERE keluarga_id = ?");
        $stmt->execute([$keluarga_id]);
    } else {
        $stmt = $pdo->query("SELECT anggota_keluarga.*, suku.nama as suku, wilayah_adat.nama as wilayah FROM anggota_keluarga LEFT JOIN suku ON anggota_keluarga.suku_id = suku.id LEFT JOIN wilayah_adat ON anggota_keluarga.wilayah_adat_id = wilayah_adat.id");
    }
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

// Tambah anggota keluarga
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $nik = $input['nik'] ?? '';
    $nama = $input['nama_lengkap'] ?? '';
    $jk = $input['jenis_kelamin'] ?? '';
    $tmp = $input['tempat_lahir'] ?? '';
    $tgl = $input['tanggal_lahir'] ?? NULL;
    $status = $input['status_hubungan'] ?? '';
    $keluarga_id = $input['keluarga_id'] ?? 0;
    $wilayah_adat_id = $input['wilayah_adat_id'] ?? NULL;
    $suku_id = $input['suku_id'] ?? NULL;
    if ($nik && $nama && $jk && $status && $keluarga_id) {
        $stmt = $pdo->prepare("INSERT INTO anggota_keluarga (nik, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, status_hubungan, keluarga_id, wilayah_adat_id, suku_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nik, $nama, $jk, $tmp, $tgl, $status, $keluarga_id, $wilayah_adat_id, $suku_id]);
        echo json_encode(['message' => 'Anggota keluarga berhasil ditambah']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Data tidak lengkap']);
    }
    exit;
}
