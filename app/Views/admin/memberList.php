<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Daftar Member</h1>
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
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>No.HP</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($user['username']) ?></td>
                                        <td><?= esc($user['email']) ?></td>
                                        <td><?= esc($user['number']) ?></td>
                                        <td><?= !empty($user['RegDate']) ? date('d M Y H:i', strtotime($user['RegDate'])) : '-' ?></td>
                                        <td>
                                            <form action="<?= base_url('/admin/deleteuser/' . $user['id_user']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($users)) : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data Member.</td>
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
