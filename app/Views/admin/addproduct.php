<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Produk</h1>
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

                        <form method="post" action="<?= base_url('admin/storeProduct') ?>" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="form-group mb-3">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" value="<?= old('nama_produk') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required><?= old('deskripsi') ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" class="form-control" value="<?= old('harga') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" class="form-control" value="<?= old('stok') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="Image">Gambar Produk</label>
                                <input type="file" name="Image" class="form-control" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Tambah Produk</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->include('template/admin/footer') ?>
