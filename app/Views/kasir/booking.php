<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <h1>Assign Layanan Member</h1>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">

                <!-- TABEL DATA BOOKING -->
                <?php if (!empty($booking)): ?>
                    <h5>Data Booking</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Member</th>
                                    <th>Nama Layanan</th>
                                    <th>Pegawai</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($booking as $b): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= esc($b['username']) ?></td>
                                        <td><?= esc($b['ServiceName']) ?></td>
                                        <td>
                                            <?php if (!empty($b['id_pegawai'])): ?>
                                                <?= esc($b['nama']) ?>
                                            <?php else: ?>
                                                <span class="text-danger fst-italic">Belum ditentukan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($b['status']) ?></td>
                                        <td><?= date('l, d F Y H:i', strtotime($b['tanggal'])) ?></td>
                                        <td class="text-center">
                                            <!-- Tombol Assign -->
                                            <?php if ($b['status'] == 'Menunggu'): ?>
                                                <button type="button"
                                                    class="btn btn-sm btn-success mb-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmAssignModal<?= $b['id_booking'] ?>">
                                                    Assign
                                                </button>
                                                <br>
                                                <!-- Tombol Assign Promo -->
                                                <button type="button"
                                                    class="btn btn-sm btn-warning mt-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#assignPromoModal<?= $b['id_booking'] ?>">
                                                    Assign Promo
                                                </button>
                                            <?php else: ?>
                                                Sudah
                                            <?php endif ?>

                                            <!-- Modal Konfirmasi Assign (yang lama, tetap ada) -->
                                            <div class="modal fade"
                                                id="confirmAssignModal<?= $b['id_booking'] ?>"
                                                tabindex="-1"
                                                aria-labelledby="modalLabel<?= $b['id_booking'] ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form method="post" action="<?= base_url('kasir/booking-assign/' . $b['id_booking']) ?>">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalLabel<?= $b['id_booking'] ?>">Konfirmasi Assign</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Yakin ingin assign layanan untuk booking tanggal <strong><?= date('l, d F Y H:i', strtotime($b['tanggal'])) ?></strong>?</p>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal Reschedule</label>
                                                                    <input type="datetime-local"
                                                                        name="tanggal"
                                                                        class="form-control"
                                                                        value="<?= esc($b['tanggal']) ?>"
                                                                        required>
                                                                </div>
                                                                <?php if (empty($b['id_pegawai'])): ?>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Pilih Pegawai</label>
                                                                        <select name="id_pegawai" class="form-select" required>
                                                                            <option value="">-- Pilih Pegawai --</option>
                                                                            <?php foreach ($pegawai as $pg): ?>
                                                                                <option value="<?= $pg['id_pegawai'] ?>"><?= esc($pg['nama']) ?></option>
                                                                            <?php endforeach ?>
                                                                        </select>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">Yakin, Assign</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Assign Promo -->
                                            <div class="modal fade"
                                                id="assignPromoModal<?= $b['id_booking'] ?>"
                                                tabindex="-1"
                                                aria-labelledby="assignPromoLabel<?= $b['id_booking'] ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form method="post" action="<?= base_url('kasir/booking-assign/' . $b['id_booking']) . '/true' ?>">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="assignPromoLabel<?= $b['id_booking'] ?>">Assign Promo</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Nama Member:</strong> <?= esc($b['username']) ?></p>
                                                                <p><strong>Nama Layanan:</strong> <?= esc($b['ServiceName']) ?></p>
                                                                <p><strong>Tanggal:</strong> <?= date('l, d F Y H:i', strtotime($b['tanggal'])) ?></p>

                                                                <div class="mb-3">
                                                                    <label for="harga_promo_<?= $b['id_booking'] ?>" class="form-label">Harga Promo</label>
                                                                    <input type="number" name="harga_promo" class="form-control" id="harga_promo_<?= $b['id_booking'] ?>" required min="0">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal Reschedule</label>
                                                                    <input type="datetime-local"
                                                                        name="tanggal"
                                                                        class="form-control"
                                                                        value="<?= esc($b['tanggal']) ?>"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="id_pegawai_<?= $b['id_booking'] ?>" class="form-label">Pilih Pegawai</label>
                                                                    <select name="id_pegawai" class="form-select" id="id_pegawai_<?= $b['id_booking'] ?>" required>
                                                                        <option value="">-- Pilih Pegawai --</option>
                                                                        <?php foreach ($pegawai as $pg): ?>
                                                                            <option value="<?= $pg['id_pegawai'] ?>"><?= esc($pg['nama']) ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-warning">Simpan Promo</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Tidak ada data booking untuk ditampilkan.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?= $this->include('template/footer2') ?>