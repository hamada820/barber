<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Daftar Layanan</h1>
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
                                    <th>Nama Layanan</th>
                                    <th>Deskripsi</th>
                                    <th>Biaya</th>
                                    <th>Gambar</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($services as $service) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($service['ServiceName']) ?></td>
                                        <td><?= esc($service['ServiceDescription']) ?></td>
                                        <td>Rp<?= number_format($service['Cost'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if (!empty($service['Image']) && file_exists(FCPATH . 'uploads/services/' . $service['Image'])) : ?>
                                                <img src="<?= base_url('uploads/services/' . $service['Image']) ?>" width="100">
                                            <?php else : ?>
                                                <em>Tidak ada gambar</em>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M Y H:i', strtotime($service['CreationDate'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('/admin/editservice/' . $service['id_service']) ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="<?= base_url('/admin/deleteservice/' . $service['id_service']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($services)) : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data layanan.</td>
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
