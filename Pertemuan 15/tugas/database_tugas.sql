USE unpam_web;

CREATE TABLE IF NOT EXISTS krina_dosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS krina_matkul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matkul VARCHAR(100) NOT NULL,
    sks INT NOT NULL
);

CREATE TABLE IF NOT EXISTS krina_jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_dosen INT NOT NULL,
    id_matkul INT NOT NULL,
    waktu VARCHAR(50) NOT NULL,
    ruang VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_dosen) REFERENCES krina_dosen(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matkul) REFERENCES krina_matkul(id) ON DELETE CASCADE
);

INSERT INTO krina_dosen (nama, alamat) VALUES
('Prof. Dr. Bambang Wijaya', 'Jl. Merdeka No. 10, Jakarta'),
('Dr. Siti Rahmawati', 'Jl. Sudirman No. 25, Bandung'),
('Ir. Agus Prasetyo', 'Jl. Diponegoro No. 5, Surabaya'),
('Dra. Dewi Sartika', 'Jl. Ahmad Yani No. 15, Medan'),
('Dr. Rudi Hartono', 'Jl. Gajah Mada No. 8, Semarang');

INSERT INTO krina_matkul (matkul, sks) VALUES
('Pemrograman Web', 3),
('Basis Data', 3),
('Struktur Data', 3),
('Jaringan Komputer', 3),
('Kecerdasan Buatan', 3);

INSERT INTO krina_jadwal (id_dosen, id_matkul, waktu, ruang) VALUES
(1, 1, 'Senin 08:00-10:00', 'Ruang A101'),
(2, 2, 'Selasa 10:00-12:00', 'Ruang B202'),
(3, 3, 'Rabu 13:00-15:00', 'Ruang A103'),
(4, 4, 'Kamis 08:00-10:00', 'Ruang C301'),
(5, 5, 'Jumat 09:00-11:00', 'Ruang B201');
