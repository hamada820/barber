<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <h1>Assign Layanan untuk <?= esc($user['username']) ?></h1>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">

                <form method="post" action="<?= base_url('kasir/assign/' . $user['id_user']) ?>">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($layanan as $service): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($service['ServiceName']) ?></td>
                                <td>Rp. <?= number_format($service['Cost']) ?></td>
                                <td class="text-center">
                                    <input type="checkbox" name="sids[]" value="<?= $service['id_service'] ?>">
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <div class="mb-3">
                        <label for="pegawai" class="form-label">Pilih Barber</label>
                        <select name="id_pegawai" class="form-control" required>
                            <option value="">-- Pilih Barber --</option>
                            <?php foreach ($pegawai as $pg): ?>
                                <option value="<?= $pg['id_pegawai'] ?>"><?= esc($pg['nama']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Assign</button>
                        <a href="<?= base_url('kasir/pelanggan') ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </section>
</main>

<?= $this->include('template/footer2') ?>
