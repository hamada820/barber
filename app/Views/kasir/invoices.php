<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Daftar Invoice</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body pt-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Member</th>
                                    <th>Email</th>
                                    <th>Layanan</th>
                                    <th>Billing ID</th>
                                    <th>Tanggal Invoice</th>
                                    <th>Total Dibayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($invoices)) : ?>
                                    <?php $no = 1; foreach ($invoices as $invoice) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($invoice['username']) ?></td>
                                            <td><?= esc($invoice['email']) ?></td>
                                            <td><?= esc($invoice['ServiceName']) ?></td>
                                            <td><?= esc($invoice['BillingId']) ?></td>
                                            <td><?= date('d M Y H:i', strtotime($invoice['PostingDate'])) ?></td>
                                            <td>Rp<?= number_format($invoice['AmountPaid'], 0, ',', '.') ?></td>
                                            <td>
                                                <a href="<?= base_url('kasir/view_invoices/' . $invoice['id_invoice']) ?>" class="btn btn-info btn-sm">Lihat</a>
                                                <form action="<?= base_url('kasir/deleteinvoice/' . $invoice['id_invoice']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus invoice ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data invoice.</td>
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

<?= $this->include('template/footer2') ?>
