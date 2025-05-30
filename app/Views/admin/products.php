<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Daftar Produk</h1>
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
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Gambar</th>
                                    <th>Stok</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($products as $product) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($product['nama_produk']) ?></td>
                                        <td><?= esc($product['deskripsi']) ?></td>
                                        <td>Rp<?= number_format($product['harga'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if (!empty($product['Image']) && file_exists(FCPATH . 'uploads/products/' . $product['Image'])) : ?>
                                                <img src="<?= base_url('uploads/products/' . $product['Image']) ?>" width="100">
                                            <?php else : ?>
                                                <em>Tidak ada gambar</em>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($product['stok']) ?></td>
                                        <td><?= !empty($product['created_at']) ? date('d M Y H:i', strtotime($product['created_at'])) : '-' ?></td>
                                        <td><?= !empty($product['updated_at']) ? date('d M Y H:i', strtotime($product['updated_at'])) : '-' ?></td>
                                        <td>
                                            <a href="<?= base_url('/admin/editproduct/' . $product['id_produk']) ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="<?= base_url('/admin/deleteproduct/' . $product['id_produk']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus Produk ini?')">
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($products)) : ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data Produk.</td>
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
