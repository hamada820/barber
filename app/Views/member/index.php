`<?= $this->extend('template/inc/layout') ?>
<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')) : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
<section class="hero container">
  <div class="mt-5">
    <div class="row ms-3">
      <div class="col-md-6">
        <h1 class="fw-bold">Kharisma <br /> Barbershop</h1>
        <h1>Halo <?= esc(session()->get('username')) ?></h1>
        <p class="text-muted mt-3">
          Setidaknya Anda Sudah Tampan, Meski Barbershop Itu Adalah Sebuah Pilihan
        <div id="typing">Jam Buka 10.00-22.00 WITA</div>
        <div id="line">|</div>
        </p>
      </div>
      <div class="col-md-6 mt-2">
        <img class="img-banner img-fluid" src="<?= base_url('assets/img/banner.svg') ?>" alt="barber logo" width="500px" />
      </div>
    </div>
  </div>
</section>

<div class="container mt-5">
  <?php if (!empty($booked)) : ?>
    <section class="container mb-5">
      <h3 class="fw-bold ms-3">Booking Anda <span class="text-theme">Saat Ini</span></h3>
      <hr>
      <div class="row ms-3">
        <?php foreach ($booked as $b) : ?>
          <div class="col-md-4 mt-2">
            <div class="card border-radius-10 p-3 shadow-sm">
              <h5>Status:
                <?php if ($b['status'] == 'Assigned'): ?>
                  <span class="badge bg-success">Dikonfirmasi</span>
                <?php elseif ($b['status'] == 'Menunggu'): ?>
                  <span class="badge bg-warning text-dark">Menunggu</span>
                <?php endif; ?>
              </h5>
              <p><strong>Tanggal Booking:</strong> <?= date('d M Y H:i', strtotime($b['tanggal'])) ?></p>
              <p><strong>Nama Layanan:</strong> <?= esc($b['ServiceName']) ?></p>
              <p><strong>Nama Pegawai:</strong> <?= esc($b['nama']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php else: ?>
    <section class="container mb-5">
      <h5 class="ms-3 text-muted">Anda belum melakukan booking layanan apapun.</h5>
    </section>
  <?php endif; ?>
  <section class="popular-barber bg-theme pt-2 pb-2 mt-5">
    <div class="container">
      <div class="row">
        <h3 class="fw-bold ms-3">Layanan <span class="text-theme">Tersedia</span></h3>
        <hr>
      </div>

      <div class="row mt-3">
        <?php if (!empty($services)): ?>
          <?php foreach ($services as $service): ?>
            <div class="col-md-4 mt-3">
              <div class="card border-radius-10 p-2">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <img src="<?= base_url('uploads/services/' . $service['Image']) ?>" alt="<?= esc($service['ServiceName']) ?>" width="100" class="border-radius-10 img-fluid" />
                    </div>
                    <div class="col-md-8 mt-2">
                      <h5 class="ms-2 fw-bold"><?= esc($service['ServiceName']) ?></h5>
                      <small class="ms-2 fw-bold text-theme">Produk Tersedia</small><br />
                    </div>
                  </div>
                  <h5 class="fw-bold ms-1 mt-4">Deskripsi Produk</h5>
                  <h5 class="font-weight-bold price-theme mt-3 ms-1">Harga: Rp.<?= number_format($service['Cost'], 0, ',', '.') ?></h5>
                </div>
                <div class="text-center mt-3">
                  <button class="btn btn-color-theme pe-4 ps-4 pt-2 mt-3" data-bs-toggle="modal" data-bs-target="#modalBeli<?= $service['id_service'] ?>">Beli</button>
                </div>
              </div>
            </div>
            <!-- Modal Beli Produk -->
            <div class="modal fade" id="modalBeli<?= $service['id_service'] ?>" tabindex="-1" aria-labelledby="modalBeliLabel<?= $service['id_service'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?= base_url('member/beli-layanan') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="jumlah" value="1">
                    <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title" id="modalBeliLabel<?= $service['id_service'] ?>">Beli Produk</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="id_service" value="<?= esc($service['id_service']) ?>">

                      <!-- Tambahan: Gambar Produk -->
                      <div class="text-center mb-3">
                        <img src="<?= base_url('uploads/services/' . $service['Image']) ?>" alt="<?= esc($service['ServiceName']) ?>" class="img-fluid rounded" style="max-height: 200px;">
                      </div>

                      <p class="fw-bold text-center"><?= esc($service['ServiceName']) ?></p>
                      <p class="text-center">Harga: <strong>Rp <?= number_format($service['Cost'], 0, ',', '.') ?></strong></p>

                      <div class="mb-3">
                        <label for="jumlah<?= $service['id_service'] ?>" class="form-label">Jumlah:</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="tanggal<?= $service['id_service'] ?>" class="form-label">Pilih Tanggal Booking:</label>
                      <input type="datetime-local" class="form-control" name="tanggal" id="tanggal<?= $service['id_service'] ?>" required>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Kirim Permintaan</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center">Tidak ada layanan tersedia.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <section class="popular-barber bg-theme pt-2 pb-2 mt-5">
    <div class="container">
      <div class="row">
        <h3 class="fw-bold ms-3">Produk <span class="text-theme">Tersedia</span></h3>
        <hr>
      </div>

      <div class="row mt-3">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $product): ?>
            <div class="col-md-4 mt-3">
              <div class="card border-radius-10 p-2">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <img src="<?= base_url('uploads/products/' . $product['Image']) ?>" alt="<?= esc($product['nama_produk']) ?>" width="100" class="border-radius-10 img-fluid" />
                    </div>
                    <div class="col-md-8 mt-2">
                      <h5 class="ms-2 fw-bold"><?= esc($product['nama_produk']) ?></h5>
                      <small class="ms-2 fw-bold text-theme">Produk Tersedia</small><br />
                      <small class="text-muted ms-2"><i data-feather="package" width="16px"></i> Stok: <?= esc($product['stok']) ?></small>
                    </div>
                  </div>
                  <h5 class="fw-bold ms-1 mt-4">Deskripsi Produk</h5>
                  <p class="text-muted ms-1 mb-2"><?= esc($product['deskripsi']) ?></p>
                  <h5 class="font-weight-bold price-theme mt-3 ms-1">Harga: Rp.<?= number_format($product['harga'], 0, ',', '.') ?></h5>
                </div>
                <div class="text-center mt-3">
                  <button class="btn btn-color-theme pe-4 ps-4 pt-2 mt-3" data-bs-toggle="modal" data-bs-target="#modalBeli<?= $product['id_produk'] ?>">Beli</button>
                </div>
              </div>
            </div>
            <!-- Modal Beli Produk -->
            <div class="modal fade" id="modalBeli<?= $product['id_produk'] ?>" tabindex="-1" aria-labelledby="modalBeliLabel<?= $product['id_produk'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?= base_url('member/beli-produk') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title" id="modalBeliLabel<?= $product['id_produk'] ?>">Beli Produk</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="id_produk" value="<?= esc($product['id_produk']) ?>">

                      <!-- Tambahan: Gambar Produk -->
                      <div class="text-center mb-3">
                        <img src="<?= base_url('uploads/products/' . $product['Image']) ?>" alt="<?= esc($product['nama_produk']) ?>" class="img-fluid rounded" style="max-height: 200px;">
                      </div>

                      <p class="fw-bold text-center"><?= esc($product['nama_produk']) ?></p>
                      <p class="text-center">Harga: <strong>Rp <?= number_format($product['harga'], 0, ',', '.') ?></strong></p>
                      <p class="text-center">Stok tersedia: <strong><?= esc($product['stok']) ?></strong></p>

                      <div class="mb-3">
                        <label for="jumlah<?= $product['id_produk'] ?>" class="form-label">Jumlah:</label>
                        <input type="number" name="jumlah" class="form-control" id="jumlah<?= $product['id_produk'] ?>" min="1" max="<?= esc($product['stok']) ?>" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Kirim Permintaan</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center">Tidak ada produk tersedia.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Invoice History -->
  <section class="mb-5">
  <h2 class="text-center text-primary mb-4">Invoice History</h2>
  <div class="table-responsive">
    <table class="table table-bordered text-center">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Invoice ID</th>
          <th>Jumlah Dibayar</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($invoices)): $no = 1; ?>
          <?php foreach ($invoices as $row): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= esc($row['BillingId']) ?></td>
              <td><?= esc($row['AmountPaid']) ?></td>
              <td><?= esc($row['PostingDate']) ?></td>
              <td>
                <button 
                  class="btn btn-primary btn-sm lihat-invoice" 
                  data-billingid="<?= esc($row['BillingId']) ?>"
                  data-amount="<?= esc($row['AmountPaid']) ?>"
                  data-date="<?= esc($row['PostingDate']) ?>"
                >
                  Lihat
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5">Tidak ada data invoice.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invoiceModalLabel">Detail Invoice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p><strong>Invoice ID:</strong> <span id="modalInvoiceId"></span></p>
        <p><strong>Jumlah Dibayar:</strong> <span id="modalAmount"></span></p>
        <p><strong>Tanggal:</strong> <span id="modalDate"></span></p>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.lihat-invoice');

    buttons.forEach(button => {
      button.addEventListener('click', function () {
        const invoiceId = this.dataset.billingid;
        const amount = this.dataset.amount;
        const date = this.dataset.date;

        document.getElementById('modalInvoiceId').textContent = invoiceId;
        document.getElementById('modalAmount').textContent = amount;
        document.getElementById('modalDate').textContent = date;

        const modal = new bootstrap.Modal(document.getElementById('invoiceModal'));
        modal.show();
      });
    });
  });
</script>

  <!-- Riwayat Pemotongan (Histinvoice) -->
  <section>
    <h2 class="text-center text-primary mb-4">Riwayat Pemotongan</h2>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Invoice ID</th>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Hasil</th>
            <th>Barber</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($histories)): $no = 1; ?>
            <?php foreach ($histories as $row): ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= esc($row['id_invoice']) ?></td>
                <td><?= esc($row['tanggal']) ?></td>
                <td><?= esc($row['deskripsi']) ?></td>
                <td>
                  <?php if (!empty($row['hasil'])): ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalGambar<?= $row['id_history'] ?>">
                      <img src="<?= base_url($row['hasil']) ?>" alt="Hasil" width="80" height="80" class="img-thumbnail" style="object-fit:cover;">
                    </a>
                  <?php else: ?>
                    <span>Tidak ada gambar</span>
                  <?php endif; ?>
                </td>
                <td><?= esc($row['id_pegawai'] . ' - ' . $row['nama_pegawai']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">Tidak ada riwayat.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>

<!-- Modal Profil -->
<div class="modal fade" id="modalProfil" tabindex="-1" aria-labelledby="modalProfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalProfilLabel">Profil Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <?= view('template/inc/profile-section') ?>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
`