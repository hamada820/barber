<?php

use App\Models\PegawaiModel;
use App\Models\ServiceModel;

$layananModel  = new ServiceModel(); // nama modelmu untuk layanan
$pegawaiModel  = new PegawaiModel(); // pastikan model ini sudah ada

?>
<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <h1>Data Non-Pelanggan</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNonMemberModal">
            <i class="bi bi-plus-circle"></i> Tambah Data
        </button>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Pegawai</th>
                            <th>Layanan</th>
                            <th>Ciri Khusus</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data non-pelanggan</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            foreach ($data as $item):
                                $pegawai = $pegawaiModel->find($item['id_pegawai']);
                                $service = $layananModel->find($item['id_service']);
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= esc($pegawai['nama'] ?? 'Unknown') ?></td>
                                    <td><?= esc($service['ServiceName'] ?? 'Unknown') ?></td>
                                    <td><?= esc($item['ciri'] ?? '-') ?></td>
                                    <td class="text-center"><?= date('d-m-Y H:i', strtotime($item['tanggal'])) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning edit-btn" data-id="<?= $item['id_nonmember'] ?>"
                                            data-pegawai="<?= $item['id_pegawai'] ?>" data-service="<?= $item['id_service'] ?>"
                                            data-ciri="<?= $item['ciri'] ?>"
                                            data-tanggal="<?= date('Y-m-d\TH:i', strtotime($item['tanggal'])) ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $item['id_nonmember'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<!-- Add Modal -->
<div class="modal fade" id="addNonMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('kasir/nonpelanggan/store') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Non-Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pegawai" class="form-label">Pegawai</label>
                        <select class="form-select" id="pegawai" name="id_pegawai" required>
                            <option value="">Pilih Pegawai</option>
                            <?php foreach ($pegawaiList as $pegawai): ?>
                                <option value="<?= $pegawai['id_pegawai'] ?>"><?= esc($pegawai['nama']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="service" class="form-label">Layanan</label>
                        <select class="form-select" id="service" name="id_service" required>
                            <option value="">Pilih Layanan</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id_service'] ?>"><?= esc($service['ServiceName']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ciri" class="form-label">Ciri Khusus</label>
                        <textarea class="form-control" id="ciri" name="ciri" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editNonMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Non-Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_pegawai" class="form-label">Pegawai</label>
                        <select class="form-select" id="edit_pegawai" name="id_pegawai" required>
                            <option value="">Pilih Pegawai</option>
                            <?php foreach ($pegawaiList as $pegawai): ?>
                                <option value="<?= $pegawai['id_pegawai'] ?>"><?= esc($pegawai['nama']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_service" class="form-label">Layanan</label>
                        <select class="form-select" id="edit_service" name="id_service" required>
                            <option value="">Pilih Layanan</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id_service'] ?>"><?= esc($service['ServiceName']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_ciri" class="form-label">Ciri Khusus</label>
                        <textarea class="form-control" id="edit_ciri" name="ciri" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteNonMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Button Handler
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const pegawai = this.getAttribute('data-pegawai');
                const service = this.getAttribute('data-service');
                const ciri = this.getAttribute('data-ciri');
                const tanggal = this.getAttribute('data-tanggal');

                document.getElementById('editForm').action =
                    `<?= base_url('kasir/nonpelanggan/update/') ?>${id}`;
                document.getElementById('edit_pegawai').value = pegawai;
                document.getElementById('edit_service').value = service;
                document.getElementById('edit_ciri').value = ciri;
                document.getElementById('edit_tanggal').value = tanggal;

                const modal = new bootstrap.Modal(document.getElementById('editNonMemberModal'));
                modal.show();
            });
        });

        // Delete Button Handler
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('deleteForm').action =
                    `<?= base_url('kasir/nonpelanggan/delete/') ?>${id}`;

                const modal = new bootstrap.Modal(document.getElementById('deleteNonMemberModal'));
                modal.show();
            });
        });
    });
</script>

<?= $this->include('template/footer2') ?>