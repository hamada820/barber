<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>
<?php helper('form'); ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Kelola Permintaan Pembelian Produk</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body pt-4">
        <?php if (session()->getFlashdata('pesan')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
        <?php endif; ?>

        <?= form_open('kasir/create-invoice', ['method' => 'post']) ?>

          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead class="table-dark">
                <tr>
                  <th><input type="checkbox" id="checkAll" /></th>
                  <th>#</th>
                  <th>Nama Pengguna</th>
                  <th>Produk</th>
                  <th>Gambar</th>
                  <th>Jumlah</th>
                  <th>Harga Satuan</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($pembelian)): $no = 1; ?>
                  <?php foreach ($pembelian as $row): 
                    $total = $row['jumlah'] * $row['harga']; ?>
                    <tr>
                      <td>
                        <input 
                          type="checkbox" 
                          class="checkItem" 
                          name="id_pembelian[]" 
                          value="<?= $row['id_pembelian'] ?>" 
                        />
                      </td>
                      <td><?= $no++ ?></td>
                      <td><?= esc($row['username']) ?></td>
                      <td><?= esc($row['nama_produk']) ?></td>
                      <td>
                        <img src="<?= base_url('uploads/products/' . $row['Image']) ?>"
                             alt="Gambar Produk" width="80" height="80"
                             class="img-thumbnail" style="object-fit:cover;">
                      </td>
                      <td><?= esc($row['jumlah']) ?></td>
                      <td><?= esc($row['harga']) ?></td>
                      <td><?= esc($total) ?></td>
                      <td>
                        <?php if ($row['id_invoiceproduk'] == NULL): ?>
                          <span class="badge bg-warning text-dark">Menunggu</span>
                        <?php elseif ($row['id_invoiceproduk'] != NULL): ?>
                          <span class="badge bg-success">Disetujui</span>
                        <?php else: ?>
                          <span class="badge bg-danger">Ditolak</span>
                        <?php endif; ?>
                      </td>
                      <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="10">Tidak ada permintaan pembelian.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="mt-3 text-end">
            <button type="submit" class="btn btn-primary" onclick="return confirm('Buat invoice untuk semua item terpilih?')">
              Buat Invoice
            </button>
          </div>
        <?= form_close() ?>
      </div>
    </div>
  </section>
</main>

<?= $this->include('template/footer2') ?>

<script>
// Hanya untuk “check all” tanpa menghitung apa-apa
document.getElementById('checkAll').addEventListener('change', function(){
  document.querySelectorAll('.checkItem').forEach(chk => chk.checked = this.checked);
});
</script>
