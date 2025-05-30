<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Tambah Layanan</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-xxl-6 col-md-8">
        <div class="card">
          <div class="card-body pt-4">

            <!-- Flash Message -->
            <?php if (session()->getFlashdata('info')) : ?>
              <div class="alert alert-primary text-center" role="alert">
                <?= session()->getFlashdata('info') ?>
              </div>
            <?php endif; ?>

            <!-- Validasi -->
            <?php if (session()->get('validation')) : ?>
              <div class="alert alert-danger">
                <?= session()->get('validation')->listErrors() ?>
              </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="<?= base_url('/admin/storeService') ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>

              <div class="form-group mb-3">
                <label for="ServiceName" class="form-label">Nama Layanan</label>
                <input type="text" class="form-control" id="ServiceName" name="ServiceName"
                  value="<?= old('ServiceName') ?>" placeholder="Nama Layanan" required>
              </div>

              <div class="form-group mb-3">
                <label for="ServiceDescription" class="form-label">Deskripsi Layanan</label>
                <textarea class="form-control" id="ServiceDescription" name="ServiceDescription" rows="4" placeholder="Deskripsi Layanan" required><?= old('ServiceDescription') ?></textarea>
              </div>

              <div class="form-group mb-3">
                <label for="Cost" class="form-label">Biaya</label>
                <input type="number" class="form-control" id="Cost" name="Cost"
                  value="<?= old('Cost') ?>" placeholder="Biaya" required>
              </div>

              <div class="form-group mb-3">
                <label for="Image" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="Image" name="Image" accept="image/*" required>
              </div>

              <button type="submit" class="btn btn-primary w-100">Tambah Layanan</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?= $this->include('template/admin/footer') ?>
