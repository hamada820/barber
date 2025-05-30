<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Daftar Pegawai</h1>
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
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($pegawai as $p) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($p['nama']) ?></td>
                                        <td><?= esc($p['alamat']) ?></td>
                                        <td><?= esc($p['telepon']) ?></td>
                                        <td>
                                            <?php if (!empty($p['image']) && file_exists(FCPATH . 'uploads/pegawai/' . $p['image'])) : ?>
                                                <img src="<?= base_url('uploads/pegawai/' . $p['image']) ?>" width="100">
                                            <?php else : ?>
                                                <em>Tidak ada foto</em>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('/admin/editPegawai/' . $p['id_pegawai']) ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="<?= base_url('/admin/deletepegawai/' . $p['id_pegawai']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($pegawai)) : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pegawai.</td>
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
