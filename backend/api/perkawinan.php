<?php
header('Content-Type: application/json');
require_once 'config.php';

// Ambil seluruh data perkawinan
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT perkawinan.*, 
        al.nik as nik_laki, al.nama_lengkap as nama_laki, sukul.nama as suku_laki, wilal.nama as wilayah_laki, 
        ap.nik as nik_perempuan, ap.nama_lengkap as nama_perempuan, sukup.nama as suku_perempuan, wilap.nama as wilayah_perempuan
        FROM perkawinan
        LEFT JOIN anggota_keluarga al ON perkawinan.anggota_laki_id = al.id
        LEFT JOIN anggota_keluarga ap ON perkawinan.anggota_perempuan_id = ap.id
        LEFT JOIN suku sukul ON al.suku_id = sukul.id
        LEFT JOIN suku sukup ON ap.suku_id = sukup.id
        LEFT JOIN wilayah_adat wilal ON al.wilayah_adat_id = wilal.id
        LEFT JOIN wilayah_adat wilap ON ap.wilayah_adat_id = wilap.id
        ORDER BY perkawinan.tanggal_perkawinan DESC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

// Tambah data perkawinan baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $laki = $input['anggota_laki_id'] ?? 0;
    $perempuan = $input['anggota_perempuan_id'] ?? 0;
    $tanggal = $input['tanggal_perkawinan'] ?? date('Y-m-d');
    $kategori = $input['kategori'] ?? NULL;
    if ($laki && $perempuan) {
        $stmt = $pdo->prepare("INSERT INTO perkawinan (anggota_laki_id, anggota_perempuan_id, tanggal_perkawinan, kategori) VALUES (?, ?, ?, ?)");
        $stmt->execute([$laki, $perempuan, $tanggal, $kategori]);
        echo json_encode(['message' => 'Data perkawinan berhasil ditambah']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Data tidak lengkap']);
    }
    exit;
}
