<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
<?php helper('url'); ?>

<!-- Banner Start -->
<section class="hero container">
  <div class="mt-5">
    <div class="row ms-3">
      <div class="col-md-6">
        <h1 class="fw-bold">
          Kharisma <br />
          Barbershop
        </h1>
        <p class="text-muted mt-3">
          Setidaknya Anda Sudah Tampan, Meski Barbershop Itu Adalah Sebuah Pilihan
          <div id="typing">Jam Buka 10.00-22.00 WITA</div>
          <div id="line">|</div>
        </p>
        <a href="<?= base_url('/login') ?>" class="btn btn-color-theme pe-4 ps-4 pt-2 mt-3">LOGIN/MASUK</a>
        <a href="<?= base_url('/register') ?>" class="btn btn-outline-theme pe-4 ps-4 pt-2 mt-3">DAFTAR AKUN SEKARANG</a>
      </div>
      <div class="col-md-6 mt-2">
        <img class="img-banner img-fluid" src="<?= base_url('assets/img/banner.svg') ?>" alt="barber logo" width="500px" />
      </div>
    </div>
  </div>
</section>
<!-- Banner End -->

<!-- Services Section -->
<section class="popular-barber bg-theme pt-2 pb-2 mt-5">
  <div class="container">
    <div class="row">
      <h3 class="fw-bold ms-3">Daftar <span class="text-theme">Layanan</span></h3>
      <hr>
    </div>
    <div class="row mt-3">
      <?php foreach ($services as $service): ?>
      <div class="col-md-4 mt-3 d-flex">
        <div class="card border-radius-10 p-2 w-100 h-100 d-flex flex-column justify-content-between">
          <div class="card-body d-flex flex-column">
            <div class="row mb-2">
              <div class="col-4">
                <img src="<?= base_url('admin/assets/img/' . $service['Image']) ?>" alt="<?= esc($service['ServiceName']) ?>" class="border-radius-10 img-fluid" style="height: 120px; object-fit: cover;" />
              </div>
              <div class="col-8">
                <h5 class="fw-bold"><?= esc($service['ServiceName']) ?></h5>
                <small class="fw-bold text-theme">Pelanggan</small><br />
                <small class="text-muted"><i data-feather="map-pin" width="16px"></i> Pelaihari, Kalimantan Selatan</small>
              </div>
            </div>
            <div class="flex-grow-1">
              <h6 class="fw-bold">Deskripsi Layanan</h6>
              <p class="text-muted mb-2" style="min-height: 60px; overflow: hidden;"><?= esc($service['ServiceDescription']) ?></p>
              <h6 class="fw-bold price-theme">Biaya layanan: Rp.<?= number_format($service['Cost'], 0, ',', '.') ?></h6>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Product Section -->
<section class="popular-barber bg-theme pt-2 pb-2 mt-5">
  <div class="container">
    <div class="row">
      <h3 class="fw-bold ms-3">Produk <span class="text-theme">Tersedia</span></h3>
      <hr>
    </div>
    <div class="row mt-3">
      <?php foreach ($products as $product): ?>
      <div class="col-md-4 mt-3 d-flex">
        <div class="card border-radius-10 p-2 w-100 h-100 d-flex flex-column justify-content-between">
          <div class="card-body d-flex flex-column">
            <div class="row mb-2">
              <div class="col-4">
                <img src="<?= base_url('uploads/products/' . $product['Image']) ?>" alt="<?= esc($product['nama_produk']) ?>" class="border-radius-10 img-fluid" style="height: 120px; object-fit: cover;" />
              </div>
              <div class="col-8">
                <h5 class="fw-bold"><?= esc($product['nama_produk']) ?></h5>
                <small class="fw-bold text-theme">Produk Tersedia</small><br />
                <small class="text-muted"><i data-feather="package" width="16px"></i> Stok: <?= esc($product['stok']) ?></small>
              </div>
            </div>
            <div class="flex-grow-1">
              <h6 class="fw-bold">Deskripsi Produk</h6>
              <p class="text-muted mb-2" style="min-height: 60px; overflow: hidden;"><?= esc($product['deskripsi']) ?></p>
              <h6 class="fw-bold price-theme">Harga: Rp.<?= number_format($product['harga'], 0, ',', '.') ?></h6>
            </div>
          </div>
          <div class="text-center pb-3">
            <button class="btn btn-color-theme pe-4 ps-4 pt-2" data-bs-toggle="modal" data-bs-target="#loginModal">
              Beli
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Pegawai Section -->
<section class="popular-barber bg-theme pt-2 pb-2 mt-5">
  <div class="container">
    <div class="row">
      <h3 class="fw-bold ms-3">Keluarga Besar <span class="text-theme">Kharisma Barbershop</span></h3>
      <hr>
    </div>
    <div class="row mt-3">
      <?php foreach ($pegawai as $pgwai): ?>
      <div class="col-md-4 mt-3 d-flex">
        <div class="card border-radius-10 p-2 w-100 h-100 d-flex flex-column justify-content-between">
          <div class="card-body d-flex flex-column">
            <div class="row align-items-center mb-3">
              <div class="col-4">
                <img src="<?= base_url('uploads/pegawai/' . $pgwai['image']) ?>" alt="Foto Pegawai" class="border-radius-10 img-fluid" style="height: 120px; object-fit: cover;" />
              </div>
              <div class="col-8">
                <h6 class="fw-bold mb-2">Nama:</h6>
                <p class="mb-2"><?= esc($pgwai['nama']) ?></p>

                <h6 class="fw-bold mb-2">Alamat:</h6>
                <p class="mb-2"><?= esc($pgwai['alamat']) ?></p>

                <h6 class="fw-bold mb-2">No. Telpon:</h6>
                <p><?= esc($pgwai['telepon']) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- Pegawai End -->

<!-- Contact Section -->
<section class="about mt-5 pd-5" id="contact">
  <div class="container">
    <div class="row mt-5">
      <!-- Gambar Kontak -->
      <div class="col-md-6">
        <img src="<?= base_url('assets/img/aboutBarber.svg') ?>" width="500px" class="img-fluid" alt="Contact Image" />
      </div>

      <!-- Form Kritik dan Saran -->
      <div class="col-md-6">
        <h2 class="fw-bold">Kritik dan Saran</h2>
        <hr>
        <form id="kritikForm" action="<?= base_url('/kritik-saran/kirim') ?>" method="post">
          <div class="row">
            <div class="col-6">
              <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required autocomplete="off">
            </div>
            <div class="col-6">
              <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
          </div>
          <textarea class="form-control message mt-3" name="pesan" maxlength="500" placeholder="Pesan" required></textarea>
          <button type="submit" class="btn btn-outline-theme pe-4 ps-4 pt-2 mt-3" name="submit">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </div>

<!-- About Us Section -->
<section id="tentangkami" class="tentangkami section-bg mt-5">
  <div class="container" data-aos="fade-up">
    <div class="section-title">
      <h2>Tentang Kami</h2>
    </div>
    <?php if (!empty($aboutData)): ?>
      <div class="mb-4">
        <h4><?= esc($aboutData['PageTitle']) ?></h4>
        <div><?= $aboutData['PageDescription'] ?></div> <!-- aman, tidak di-escape -->
      </div>
    <?php else: ?>
      <p>Data tentang kami belum tersedia.</p>
    <?php endif; ?>
  </div>
</section>


<style>
  #tentangkami iframe {
    width: 100%;
    max-width: 100%;
    height: 300px;
    border: none;
  }
</style>


<?= $this->endSection() ?>
