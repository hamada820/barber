<?= $this->include('template/admin/header') ?>
<?= $this->include('template/admin/sidebar') ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Layanan</h1>
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
            <?php if (isset($validation)) : ?>
              <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
            <?php endif; ?>

            <!-- Form -->
            <form action="<?= base_url('admin/updateservice/' . $service['id_service']) ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <div class="form-group mb-3">
                <label for="ServiceName" class="form-label">Nama Layanan</label>
                <input type="text" class="form-control" id="ServiceName" name="ServiceName"
                  value="<?= esc($service['ServiceName']) ?>" required>
              </div>

              <div class="form-group mb-3">
                <label for="ServiceDescription" class="form-label">Deskripsi Layanan</label>
                <textarea class="form-control" id="ServiceDescription" name="ServiceDescription" rows="4" required><?= esc($service['ServiceDescription']) ?></textarea>
              </div>

              <div class="form-group mb-3">
                <label for="Cost" class="form-label">Biaya</label>
                <input type="number" class="form-control" id="Cost" name="Cost"
                  value="<?= esc($service['Cost']) ?>" required>
              </div>

              <div class="form-group mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                <?php if (!empty($service['Image']) && file_exists(FCPATH . 'uploads/services/' . $service['Image'])) : ?>
                  <img src="<?= base_url('uploads/services/' . $service['Image']) ?>" width="150">
                <?php else : ?>
                  <em>Tidak ada gambar</em>
                <?php endif; ?>
              </div>

              <div class="form-group mb-3">
                <label for="Image" class="form-label">Ganti Gambar (Opsional)</label>
                <input type="file" class="form-control" id="Image" name="Image" accept="image/*">
              </div>

              <button type="submit" class="btn btn-primary w-100">Update Layanan</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?= $this->include('template/admin/footer') ?>
