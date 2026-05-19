-- Database Schema for Papua Kinship System
-- 7 Wilayah Adat Papua
CREATE TABLE wilayah_adat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO wilayah_adat (nama) VALUES
  ('Bomberai'),
  ('Doberai'),
  ('Saireri'),
  ('Animha'),
  ('Wepago'),
  ('Lapago'),
  ('Tabi');

CREATE TABLE suku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    wilayah_adat_id INT,
    FOREIGN KEY (wilayah_adat_id) REFERENCES wilayah_adat(id)
);

CREATE TABLE keluarga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nik_kepala_keluarga VARCHAR(50) NOT NULL UNIQUE,
    nama_kepala_keluarga VARCHAR(100) NOT NULL,
    alamat TEXT,
    wilayah_adat_id INT,
    suku_id INT,
    FOREIGN KEY (wilayah_adat_id) REFERENCES wilayah_adat(id),
    FOREIGN KEY (suku_id) REFERENCES suku(id)
);

CREATE TABLE anggota_keluarga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(50) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P'),
    tempat_lahir VARCHAR(100),
    tanggal_lahir DATE,
    status_hubungan VARCHAR(50),  -- anak, istri, keponakan, dll
    keluarga_id INT,
    wilayah_adat_id INT,
    suku_id INT,
    FOREIGN KEY (keluarga_id) REFERENCES keluarga(id),
    FOREIGN KEY (wilayah_adat_id) REFERENCES wilayah_adat(id),
    FOREIGN KEY (suku_id) REFERENCES suku(id)
);

CREATE TABLE perkawinan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anggota_laki_id INT NOT NULL,
    anggota_perempuan_id INT NOT NULL,
    tanggal_perkawinan DATE,
    kategori VARCHAR(10),
    FOREIGN KEY (anggota_laki_id) REFERENCES anggota_keluarga(id),
    FOREIGN KEY (anggota_perempuan_id) REFERENCES anggota_keluarga(id)
);