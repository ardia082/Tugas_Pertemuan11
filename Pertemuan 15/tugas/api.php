<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['login'])) {
    echo json_encode(['status' => 'error', 'message' => 'Akses ilegal. Silakan login.']);
    exit;
}

include '../koneksi.php';

$entity = $_GET['entity'] ?? '';
$action = $_GET['action'] ?? '';

// ============ DOSEN ============
if ($entity == 'dosen') {
    if ($action == 'list') {
        $q = mysqli_query($conn, "SELECT * FROM krina_dosen ORDER BY id DESC");
        $data = [];
        while ($r = mysqli_fetch_assoc($q)) $data[] = $r;
        echo json_encode($data);
        exit;
    }
    if ($action == 'get') {
        $id = intval($_GET['id']);
        $q = mysqli_query($conn, "SELECT * FROM krina_dosen WHERE id=$id");
        echo json_encode(mysqli_fetch_assoc($q));
        exit;
    }
    if ($action == 'save') {
        $id = $_POST['id'] ?? '';
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
        if (empty($id)) {
            $sql = "INSERT INTO krina_dosen (nama, alamat) VALUES ('$nama', '$alamat')";
        } else {
            $sql = "UPDATE krina_dosen SET nama='$nama', alamat='$alamat' WHERE id=$id";
        }
        echo json_encode(['status' => mysqli_query($conn, $sql) ? 'success' : 'error', 'message' => mysqli_error($conn)]);
        exit;
    }
    if ($action == 'delete') {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM krina_dosen WHERE id=$id";
        echo json_encode(['status' => mysqli_query($conn, $sql) ? 'success' : 'error', 'message' => mysqli_error($conn)]);
        exit;
    }
}

// ============ MATKUL ============
if ($entity == 'matkul') {
    if ($action == 'list') {
        $q = mysqli_query($conn, "SELECT * FROM krina_matkul ORDER BY id DESC");
        $data = [];
        while ($r = mysqli_fetch_assoc($q)) $data[] = $r;
        echo json_encode($data);
        exit;
    }
    if ($action == 'get') {
        $id = intval($_GET['id']);
        $q = mysqli_query($conn, "SELECT * FROM krina_matkul WHERE id=$id");
        echo json_encode(mysqli_fetch_assoc($q));
        exit;
    }
    if ($action == 'save') {
        $id = $_POST['id'] ?? '';
        $matkul = mysqli_real_escape_string($conn, $_POST['matkul']);
        $sks = intval($_POST['sks']);
        if (empty($id)) {
            $sql = "INSERT INTO krina_matkul (matkul, sks) VALUES ('$matkul', $sks)";
        } else {
            $sql = "UPDATE krina_matkul SET matkul='$matkul', sks=$sks WHERE id=$id";
        }
        echo json_encode(['status' => mysqli_query($conn, $sql) ? 'success' : 'error', 'message' => mysqli_error($conn)]);
        exit;
    }
    if ($action == 'delete') {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM krina_matkul WHERE id=$id";
        echo json_encode(['status' => mysqli_query($conn, $sql) ? 'success' : 'error', 'message' => mysqli_error($conn)]);
        exit;
    }
}

// ============ JADWAL ============
if ($entity == 'jadwal') {
    if ($action == 'list') {
        $q = mysqli_query($conn, "SELECT j.id, j.id_dosen, j.id_matkul, j.waktu, j.ruang, d.nama as nama_dosen, m.matkul as nama_matkul FROM krina_jadwal j JOIN krina_dosen d ON j.id_dosen = d.id JOIN krina_matkul m ON j.id_matkul = m.id ORDER BY j.id DESC");
        $data = [];
        while ($r = mysqli_fetch_assoc($q)) $data[] = $r;
        echo json_encode($data);
        exit;
    }
    if ($action == 'get') {
        $id = intval($_GET['id']);
        $q = mysqli_query($conn, "SELECT * FROM krina_jadwal WHERE id=$id");
        echo json_encode(mysqli_fetch_assoc($q));
        exit;
    }
    if ($action == 'save') {
        $id = $_POST['id'] ?? '';
        $id_dosen = intval($_POST['id_dosen']);
        $id_matkul = intval($_POST['id_matkul']);
        $waktu = mysqli_real_escape_string($conn, $_POST['waktu']);
        $ruang = mysqli_real_escape_string($conn, $_POST['ruang']);
        if (empty($id)) {
            $sql = "INSERT INTO krina_jadwal (id_dosen, id_matkul, waktu, ruang) VALUES ($id_dosen, $id_matkul, '$waktu', '$ruang')";
        } else {
            $sql = "UPDATE krina_jadwal SET id_dosen=$id_dosen, id_matkul=$id_matkul, waktu='$waktu', ruang='$ruang' WHERE id=$id";
        }
        echo json_encode(['status' => mysqli_query($conn, $sql) ? 'success' : 'error', 'message' => mysqli_error($conn)]);
        exit;
    }
    if ($action == 'delete') {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM krina_jadwal WHERE id=$id";
        echo json_encode(['status' => mysqli_query($conn, $sql) ? 'success' : 'error', 'message' => mysqli_error($conn)]);
        exit;
    }
}

// ============ OPTIONS (for dropdowns) ============
if ($entity == 'options') {
    if ($action == 'dosen') {
        $q = mysqli_query($conn, "SELECT id, nama FROM krina_dosen ORDER BY nama");
        $data = [];
        while ($r = mysqli_fetch_assoc($q)) $data[] = $r;
        echo json_encode($data);
        exit;
    }
    if ($action == 'matkul') {
        $q = mysqli_query($conn, "SELECT id, matkul FROM krina_matkul ORDER BY matkul");
        $data = [];
        while ($r = mysqli_fetch_assoc($q)) $data[] = $r;
        echo json_encode($data);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Aksi tidak dikenal']);
