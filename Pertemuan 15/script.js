document.addEventListener('DOMContentLoaded', loadData);

const mModal = new bootstrap.Modal(document.getElementById('mahasiswaModal'));

function loadData() {
    fetch('api.php?action=list')
        .then(response => response.json())
        .then(data => {
            let html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="6" class="text-center text-muted p-4">Belum ada data mahasiswa.</td></tr>';
            } else {
                data.forEach((mhs, index) => {
                    html += `
                        <tr>
                            <td class="ps-3 align-middle">${index + 1}</td>
                            <td class="align-middle">${mhs.nim}</td>
                            <td class="align-middle">${mhs.nama}</td>
                            <td class="align-middle">${mhs.jurusan}</td>
                            <td class="align-middle">${mhs.email}</td>
                            <td class="text-center align-middle">
                                <button class="btn btn-warning btn-sm me-1" onclick="siapkanEdit(${mhs.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="hapusData(${mhs.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
            }
            document.getElementById('tempat-data-mahasiswa').innerHTML = html;
        })
        .catch(err => console.error("Gagal memuat data: ", err));
}

function siapkanTambah() {
    document.getElementById('modalTitle').innerText = 'Tambah Data Mahasiswa';
    document.getElementById('formMahasiswa').reset();
    document.getElementById('mahasiswa_id').value = '';
}

function siapkanEdit(id) {
    document.getElementById('modalTitle').innerText = 'Ubah Data Mahasiswa';
    document.getElementById('formMahasiswa').reset();

    fetch(`api.php?action=get_single&id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('mahasiswa_id').value = data.id;
            document.getElementById('nim').value = data.nim;
            document.getElementById('nama').value = data.nama;
            document.getElementById('jurusan').value = data.jurusan;
            document.getElementById('email').value = data.email;

            mModal.show();
        })
        .catch(err => console.error("Gagal mengambil data detail: ", err));
}

function simpanData(event) {
    event.preventDefault();

    const form = document.getElementById('formMahasiswa');
    const formData = new FormData(form);

    fetch('api.php?action=save', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            alert('Data berhasil disimpan!');
            mModal.hide();
            loadData();
        } else {
            alert('Error: ' + res.message);
        }
    })
    .catch(err => console.error("Gagal mengirim data: ", err));
}

function hapusData(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini secara permanen?')) {
        const formData = new FormData();
        formData.append('id', id);

        fetch('api.php?action=delete', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                alert('Data berhasil dihapus!');
                loadData();
            } else {
                alert('Error: ' + res.message);
            }
        })
        .catch(err => console.error("Gagal menghapus data: ", err));
    }
}
