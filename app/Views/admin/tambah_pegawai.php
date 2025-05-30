<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Pegawai/Kasir</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-xxl-6 col-md-8">
                <div class="card">
                    <div class="card-body pt-4">

                        <?php if (session()->getFlashdata('info')) : ?>
                            <div class="alert alert-primary text-center"><?= session()->getFlashdata('info') ?></div>
                        <?php endif; ?>

                        <?php if (isset($validation)) : ?>
                            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/simpanPegawai') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                           <div class="form-group mb-3">
    <label for="nama">Nama</label>
    <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" required>
</div>

                            <div class="form-group mb-3">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="4" required><?= old('alamat') ?></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="telepon">Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="<?= old('telepon') ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="image">Foto</label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>

                            <hr>

                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="role">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="Pegawai" <?= old('role') == 'Pegawai' ? 'selected' : '' ?>>Pegawai</option>
                                    <option value="Kasir" <?= old('role') == 'Kasir' ? 'selected' : '' ?>>Kasir</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->include('template/admin/footer') ?>
