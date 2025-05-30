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
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($absensi as $a) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($a['username']) ?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($a['jam'])) ?></td>
                                        <td>
                                            <span class="badge <?= $a['tipe'] === 'Hadir' ? 'bg-success' : 'bg-warning' ?>">
                                                <?= ucfirst($a['tipe']) ?>
                                            </span>
                                        </td>   
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($absensi)) : ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data absensi.</td>
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

<?= $this->include('template/admin/footer') ?>
