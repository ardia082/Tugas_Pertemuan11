<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CRUD Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">SIAKAD Universitas</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Halo, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <ul class="nav nav-tabs mb-4" id="tabMenu">
            <li class="nav-item">
                <button class="nav-link active" data-tab="dosen">Data Dosen</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-tab="matkul">Data Mata Kuliah</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-tab="jadwal">Data Jadwal</button>
            </li>
        </ul>

        <div id="tabContent">
            <div id="tab-dosen" class="tab-pane">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Daftar Dosen</h4>
                    <button class="btn btn-primary btn-sm" onclick="siapkanTambah('dosen')">Tambah Dosen</button>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-dosen"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-matkul" class="tab-pane d-none">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Daftar Mata Kuliah</h4>
                    <button class="btn btn-primary btn-sm" onclick="siapkanTambah('matkul')">Tambah Mata Kuliah</button>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-matkul"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-jadwal" class="tab-pane d-none">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Daftar Jadwal</h4>
                    <button class="btn btn-primary btn-sm" onclick="siapkanTambah('jadwal')">Tambah Jadwal</button>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Dosen</th>
                                        <th>Mata Kuliah</th>
                                        <th>Waktu</th>
                                        <th>Ruang</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-jadwal"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Dosen -->
    <div class="modal fade" id="modal-dosen" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-dosen">Form Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="form-dosen" onsubmit="simpanData(event, 'dosen')">
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label class="form-label">Nama Dosen</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Matkul -->
    <div class="modal fade" id="modal-matkul" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-matkul">Form Mata Kuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="form-matkul" onsubmit="simpanData(event, 'matkul')">
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label class="form-label">Nama Mata Kuliah</label>
                            <input type="text" class="form-control" name="matkul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SKS</label>
                            <input type="number" class="form-control" name="sks" min="1" max="6" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Jadwal -->
    <div class="modal fade" id="modal-jadwal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-jadwal">Form Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="form-jadwal" onsubmit="simpanData(event, 'jadwal')">
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label class="form-label">Dosen</label>
                            <select class="form-select" name="id_dosen" id="select-dosen" required>
                                <option value="">-- Pilih Dosen --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <select class="form-select" name="id_matkul" id="select-matkul" required>
                                <option value="">-- Pilih Mata Kuliah --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Waktu</label>
                            <input type="text" class="form-control" name="waktu" placeholder="Contoh: Senin 08:00-10:00" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ruang</label>
                            <input type="text" class="form-control" name="ruang" placeholder="Contoh: Ruang A101" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
