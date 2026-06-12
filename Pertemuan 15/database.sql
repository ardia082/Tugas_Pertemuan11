CREATE DATABASE IF NOT EXISTS unpam_web;
USE unpam_web;

-- Tabel users untuk login
CREATE TABLE IF NOT EXISTS krina_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabel mahasiswa untuk CRUD
CREATE TABLE IF NOT EXISTS krina_mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    jurusan VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Insert akun admin default (username: admin, password: admin123)
INSERT INTO krina_users (username, password) VALUES
('admin', '$2y$10$/WEg4i9BEhkWMLEcFHZZnOf/w2opf0YGej7sq0Mt15YO9qM7iTdBi');

-- Insert 10 data mahasiswa
INSERT INTO krina_mahasiswa (nim, nama, jurusan, email) VALUES
('202301001', 'Ahmad Fauzi', 'Teknik Informatika', 'ahmad.fauzi@email.com'),
('202301002', 'Budi Santoso', 'Sistem Informasi', 'budi.santoso@email.com'),
('202301003', 'Citra Dewi', 'Teknik Informatika', 'citra.dewi@email.com'),
('202301004', 'Dian Pratama', 'Manajemen', 'dian.pratama@email.com'),
('202301005', 'Eko Wahyudi', 'Teknik Informatika', 'eko.wahyudi@email.com'),
('202301006', 'Fitri Handayani', 'Sistem Informasi', 'fitri.handayani@email.com'),
('202301007', 'Gilang Permana', 'Manajemen', 'gilang.permana@email.com'),
('202301008', 'Hesti Nurjanah', 'Teknik Informatika', 'hesti.nurjanah@email.com'),
('202301009', 'Irfan Maulana', 'Sistem Informasi', 'irfan.maulana@email.com'),
('202301010', 'Joko Susilo', 'Manajemen', 'joko.susilo@email.com');
