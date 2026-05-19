# Papua Kinship System API & Frontend

Sistem pendataan pola perkawinan antar suku di Papua. Backend (PHP/MySQL REST API), Frontend (HTML, JS, Tailwind).

## Struktur API

### 1. Koneksi
Semua endpoint diakses via `/backend/api/<endpoint>.php`

---

### 2. Data Pokok
| Endpoint                | Method | Input (JSON)             | Keterangan       |
|------------------------|--------|--------------------------|------------------|
| wilayah_adat.php        | GET    | -                        | List wilayah     |
| suku.php                | GET    | ?wilayah_adat_id=ID      | List suku        |
| suku.php                | POST   | { nama, wilayah_adat_id }| Tambah suku      |
| keluarga.php            | GET    | -                        | List keluarga    |
| keluarga.php            | POST   | { nik_kepala_keluarga, nama_kepala_keluarga, alamat, wilayah_adat_id, suku_id } | Tambah keluarga |
| anggota_keluarga.php    | GET    | ?keluarga_id=ID          | List anggota     |
| anggota_keluarga.php    | POST   | { nik, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, status_hubungan, keluarga_id, wilayah_adat_id, suku_id } | Tambah anggota |
| perkawinan.php          | GET    | -                        | List perkawinan  |
| perkawinan.php          | POST   | { anggota_laki_id, anggota_perempuan_id, tanggal_perkawinan, kategori } | Tambah perkawinan |
| laporan.php             | GET    | ?stat=perkawinan         | Statistik perkawinan (kategori) |
| laporan.php             | GET    | ?stat=keluarga           | Statistik keluarga per wilayah |
| laporan.php             | GET    | ?stat=keluarga_suku      | Statistik keluarga per suku |

---

### 3. Contoh Request
- Untuk konsumsi via JavaScript fetch:
```js
fetch('/backend/api/keluarga.php', { method: 'GET' })
fetch('/backend/api/keluarga.php', {
  method: 'POST', headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ nik_kepala_keluarga: '123', nama_kepala_keluarga: 'Bapak X', ... })
})
```


---

## Halaman Frontend (frontend/)
- dashboard.html         → Statistik
- input-keluarga.html    → Form input keluarga
- input-perkawinan.html  → Form input perkawinan
- js/api.js              → Fungsi akses API

---

## Frontend dev setup (manual):
1. Pastikan folder frontend dan backend di-root repo
2. Pastikan file Tailwind sudah disediakan (CDN)
3. Jalankan seluruh endpoint backend di server PHP lokal
4. Edit frontend sesuai kebutuhan

---

## Pengembangan lanjutan
- Pengaman (auth) bisa ditambah session/token
- Endpoint statistik/rekap lain bisa dikembangkan
- Tambah endpoint UPDATE dan DELETE jika dibutuhkan
