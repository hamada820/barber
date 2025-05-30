<?= $this->include('template/pegawai/header') ?>
<?= $this->include('template/pegawai/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <h1>Detail Riwayat Pengguna</h1>
        <a href="<?= base_url('pegawai/riwayat') ?>" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <section class="section dashboard">
        <div class="card">
            <div class="card-body pt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Invoice</th>
                            <th>Deskripsi</th>
                            <th>Hasil</th>
                            <th>Capster</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($riwayat as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['username']) ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                <td><?= esc($row['id_invoice']) ?></td>
                                <td><?= esc($row['deskripsi']) ?></td>
                                <td>
                                    <?php if (!empty($row['hasil'])): ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalGambar<?= $row['id_history'] ?>">
                                            <img src="<?= base_url($row['hasil']) ?>" alt="Hasil" width="80" height="80" class="img-thumbnail" style="object-fit:cover;">
                                        </a>
                                    <?php else: ?>
                                        <span>Tidak ada gambar</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['capster']) ?></td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_history'] ?>">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php foreach ($riwayat as $row): ?>
                    <div class="modal fade" id="editModal<?= $row['id_history'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id_history'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= base_url('pegawai/updateRiwayat/' . $row['id_history']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $row['id_history'] ?>">Edit Riwayat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="deskripsi<?= $row['id_history'] ?>" class="form-label">Deskripsi</label>
                                            <input type="text" class="form-control" name="deskripsi" id="deskripsi<?= $row['id_history'] ?>" value="<?= esc($row['deskripsi']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="hasil<?= $row['id_history'] ?>" class="form-label">Upload Hasil (gambar)</label>
                                            <input type="file" class="form-control" name="hasil" id="hasil<?= $row['id_history'] ?>" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php foreach ($riwayat as $row): ?>
                    <?php if (!empty($row['hasil'])): ?>
                        <div class="modal fade" id="modalGambar<?= $row['id_history'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Gambar Hasil</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="<?= base_url($row['hasil']) ?>" class="img-fluid" alt="Hasil">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
        </div>
    </section>
</main>

<?= $this->include('template/pegawai/footer') ?>