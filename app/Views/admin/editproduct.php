<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>
<?php helper('form'); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Produk</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-xxl-6 col-md-8">
                <div class="card">
                    <div class="card-body pt-4">

                        <?php if (session()->getFlashdata('info')) : ?>
                            <div class="alert alert-info"><?= session()->getFlashdata('info') ?></div>
                        <?php endif; ?>

                        <?php if (isset($validation)) : ?>
                            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('/admin/updateproduct/' . $product['id_produk']) ?>" enctype="multipart/form-data">
    <input type="hidden" name="id_produk" value="<?= esc($product['id_produk']) ?>">

                            <div class="form-group mb-3">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" value="<?= esc($product['nama_produk']) ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required><?= esc($product['deskripsi']) ?></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label>Harga</label>
                                <input type="number" name="harga" class="form-control" value="<?= esc($product['harga']) ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Stok</label>
                                <input type="number" name="stok" class="form-control" value="<?= esc($product['stok']) ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Gambar Produk (biarkan kosong jika tidak ingin mengganti)</label><br>
                                <?php if (!empty($product['Image'])): ?>
                                    <img src="<?= base_url('uploads/products/' . $product['Image']) ?>" width="100" class="mb-2"><br>
                                <?php endif; ?>
                                <input type="file" name="Image" class="form-control" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-success w-100">Update Produk</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->include('template/admin/footer') ?>
