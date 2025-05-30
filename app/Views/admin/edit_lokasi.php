<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main class="main">
    <div class="pagetitle"><h1><?= $title ?></h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger"><?= implode('<br>', session()->getFlashdata('errors')) ?></div>
                <?php endif; ?>

                <form action="<?= base_url('admin/updatelokasi') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group mb-3">
                        <label>Judul</label>
                        <input type="text" name="PageTitle" class="form-control" value="<?= esc($page['PageTitle']) ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea name="PageDescription" rows="6" class="form-control" required><?= esc($page['PageDescription']) ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?= $this->include('template/admin/footer') ?>
