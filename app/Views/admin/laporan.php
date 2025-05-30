<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <a href="<?= base_url('admin/laporan/export-penjualan') ?>" class="btn btn-primary">Export Laporan Penjualan</a>
        <h1>Laporan Per Pegawai</h1>
        <a href="<?= base_url('admin/laporan/export-excel') ?>" class="btn btn-success">Export laporan Layanan</a>
    </div>

    <section class="section mt-3">
        <div class="card">
            <div class="card-body pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Total History</th>
                            <th>Total Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($laporan as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['pegawai']) ?></td>
                                <td><?= esc($row['total_history']) ?></td>
                                <td><?= esc($row['total_invoice']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?= $this->include('template/admin/footer') ?>
