let entityAktif = 'dosen';

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#tabMenu .nav-link').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('#tabMenu .nav-link').forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
            document.querySelectorAll('.tab-pane').forEach(function(p) { p.classList.add('d-none'); });
            var target = 'tab-' + this.dataset.tab;
            document.getElementById(target).classList.remove('d-none');
            entityAktif = this.dataset.tab;
            loadData(entityAktif);
        });
    });
    loadData('dosen');
});

function loadData(entity) {
    var url = 'api.php?entity=' + entity + '&action=list';
    if (entity === 'jadwal') {
        url = 'api.php?entity=jadwal&action=list';
    }

    fetch(url)
        .then(function(res) { return res.json(); })
        .then(function(data) {
            var html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="10" class="text-center text-muted p-4">Belum ada data.</td></tr>';
            } else {
                if (entity === 'dosen') {
                    data.forEach(function(item, i) {
                        html += '<tr><td class="ps-3">' + (i+1) + '</td><td>' + item.nama + '</td><td>' + item.alamat + '</td><td class="text-center"><button class="btn btn-warning btn-sm me-1" onclick="siapkanEdit(\'dosen\',' + item.id + ')">Edit</button><button class="btn btn-danger btn-sm" onclick="hapusData(\'dosen\',' + item.id + ')">Hapus</button></td></tr>';
                    });
                    document.getElementById('data-dosen').innerHTML = html;
                } else if (entity === 'matkul') {
                    data.forEach(function(item, i) {
                        html += '<tr><td class="ps-3">' + (i+1) + '</td><td>' + item.matkul + '</td><td>' + item.sks + '</td><td class="text-center"><button class="btn btn-warning btn-sm me-1" onclick="siapkanEdit(\'matkul\',' + item.id + ')">Edit</button><button class="btn btn-danger btn-sm" onclick="hapusData(\'matkul\',' + item.id + ')">Hapus</button></td></tr>';
                    });
                    document.getElementById('data-matkul').innerHTML = html;
                } else if (entity === 'jadwal') {
                    data.forEach(function(item, i) {
                        html += '<tr><td class="ps-3">' + (i+1) + '</td><td>' + item.nama_dosen + '</td><td>' + item.nama_matkul + '</td><td>' + item.waktu + '</td><td>' + item.ruang + '</td><td class="text-center"><button class="btn btn-warning btn-sm me-1" onclick="siapkanEdit(\'jadwal\',' + item.id + ')">Edit</button><button class="btn btn-danger btn-sm" onclick="hapusData(\'jadwal\',' + item.id + ')">Hapus</button></td></tr>';
                    });
                    document.getElementById('data-jadwal').innerHTML = html;
                }
            }
        })
        .catch(function(err) { console.error('Error:', err); });
}

function siapkanTambah(entity) {
    document.getElementById('title-' + entity).innerText = 'Tambah ' + entity.charAt(0).toUpperCase() + entity.slice(1);
    document.getElementById('form-' + entity).reset();
    document.getElementById('form-' + entity).querySelector('[name="id"]').value = '';

    if (entity === 'jadwal') {
        muatDropdown();
    }

    var modal = new bootstrap.Modal(document.getElementById('modal-' + entity));
    modal.show();
}

function siapkanEdit(entity, id) {
    document.getElementById('title-' + entity).innerText = 'Ubah ' + entity.charAt(0).toUpperCase() + entity.slice(1);
    document.getElementById('form-' + entity).reset();

    if (entity === 'jadwal') {
        muatDropdown();
    }

    fetch('api.php?entity=' + entity + '&action=get&id=' + id)
        .then(function(res) { return res.json(); })
        .then(function(data) {
            var form = document.getElementById('form-' + entity);
            form.querySelector('[name="id"]').value = data.id;
            form.querySelector('[name="nama"]') && (form.querySelector('[name="nama"]').value = data.nama);
            form.querySelector('[name="alamat"]') && (form.querySelector('[name="alamat"]').value = data.alamat);
            form.querySelector('[name="matkul"]') && (form.querySelector('[name="matkul"]').value = data.matkul);
            form.querySelector('[name="sks"]') && (form.querySelector('[name="sks"]').value = data.sks);
            form.querySelector('[name="waktu"]') && (form.querySelector('[name="waktu"]').value = data.waktu);
            form.querySelector('[name="ruang"]') && (form.querySelector('[name="ruang"]').value = data.ruang);
            if (form.querySelector('[name="id_dosen"]')) {
                form.querySelector('[name="id_dosen"]').value = data.id_dosen;
            }
            if (form.querySelector('[name="id_matkul"]')) {
                form.querySelector('[name="id_matkul"]').value = data.id_matkul;
            }

            var modal = new bootstrap.Modal(document.getElementById('modal-' + entity));
            modal.show();
        })
        .catch(function(err) { console.error('Error:', err); });
}

function simpanData(event, entity) {
    event.preventDefault();
    var form = document.getElementById('form-' + entity);
    var formData = new FormData(form);

    fetch('api.php?entity=' + entity + '&action=save', {
        method: 'POST',
        body: formData
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        if (res.status === 'success') {
            alert('Data berhasil disimpan!');
            var modalEl = document.getElementById('modal-' + entity);
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            loadData(entity);
        } else {
            alert('Error: ' + res.message);
        }
    })
    .catch(function(err) { console.error('Error:', err); });
}

function hapusData(entity, id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        var formData = new FormData();
        formData.append('id', id);

        fetch('api.php?entity=' + entity + '&action=delete', {
            method: 'POST',
            body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(res) {
            if (res.status === 'success') {
                alert('Data berhasil dihapus!');
                loadData(entity);
            } else {
                alert('Error: ' + res.message);
            }
        })
        .catch(function(err) { console.error('Error:', err); });
    }
}

function muatDropdown() {
    var selectDosen = document.getElementById('select-dosen');
    var selectMatkul = document.getElementById('select-matkul');

    fetch('api.php?entity=options&action=dosen')
        .then(function(res) { return res.json(); })
        .then(function(data) {
            selectDosen.innerHTML = '<option value="">-- Pilih Dosen --</option>';
            data.forEach(function(item) {
                selectDosen.innerHTML += '<option value="' + item.id + '">' + item.nama + '</option>';
            });
        });

    fetch('api.php?entity=options&action=matkul')
        .then(function(res) { return res.json(); })
        .then(function(data) {
            selectMatkul.innerHTML = '<option value="">-- Pilih Mata Kuliah --</option>';
            data.forEach(function(item) {
                selectMatkul.innerHTML += '<option value="' + item.id + '">' + item.matkul + '</option>';
            });
        });
}
