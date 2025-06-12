<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Data Absensi Pegawai</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <?php if (session()->getFlashdata('info')) : ?>
                    <div class="alert alert-success text-center">
                        <?= session()->getFlashdata('info') ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pegawai</th>
                                    <th>Waktu Absen</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($absensi as $a) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($a['username']) ?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($a['jam'])) ?></td>
                                        <td>
                                            <span class="badge <?= $a['tipe'] === 'Hadir' ? 'bg-success' : 'bg-warning' ?>">
                                                <?= ucfirst($a['tipe']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm tipe-select"
                                                data-userid="<?= $a['id_user'] ?>">
                                                <option value="">Pilih Tipe</option>
                                                <option value="Hadir" <?= $a['tipe'] === 'Hadir' ? 'selected' : '' ?>>Hadir
                                                </option>
                                                <option value="Libur" <?= $a['tipe'] === 'Libur' ? 'selected' : '' ?>>Libur
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($absensi)) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data absensi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.tipe-select');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                const tipe = this.value;
                const userId = this.getAttribute('data-userid');

                if (tipe) {
                    window.location.href = `<?= base_url('change_absen/') ?>${tipe}/${userId}`;
                }
            });
        });
    });
</script>

<?= $this->include('template/admin/footer') ?>