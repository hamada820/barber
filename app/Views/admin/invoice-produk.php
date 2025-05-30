<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Daftar Invoice produk</h1>
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
                                    <th>Grand Total</th>
                                    <th>Aksi</th>
                                 </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data)) : ?>
                                    <?php $no = 1; foreach ($data as $invoice) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($invoice['total']) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/invoiceprodukdetail/' . $invoice['id_tblinvoiceproduk']) ?>" class="btn btn-info btn-sm">Lihat</a>
                                                <form action="<?= base_url('admin/deleteinvoice/' . $invoice['id_tblinvoiceproduk']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus invoice ini?')">
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

<?= $this->include('template/admin/footer') ?>
