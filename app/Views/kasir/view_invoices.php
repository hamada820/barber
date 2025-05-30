<?php
// pastikan $title ada agar header bisa gunakan judul halaman
$title = "Detail Invoice #" . esc($invoice['id_invoice']);
?>

<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>

<main class="flex-grow-1 p-4">
    <h1><?= $title ?></h1>
    <div class="text-center mb-4">
        <img src="<?= base_url('assets/img/logokharisma.png') ?>" alt="Logo" width="170" />
    </div>


    <!-- Pegawai -->

    <!-- Services -->
    <div class="card mb-3">
        <div class="card-header bg-info text-white">Services Details</div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Layanan</th>
                        <th>Harga</th>
                        <th>Harga yang Dibayar</th>
                        <th>Capster</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cnt = 1;
                    ?>
                    <tr>
                        <td><?= $cnt++ ?></td>
                        <td><?= esc($invoice['ServiceName']) ?></td>
                        <td>Rp. <?= number_format($invoice['Cost'], 0, ',', '.') ?></td>
                        <td>Rp. <?= number_format($invoice['AmountPaid'], 0, ',', '.') ?></td>
                        <td>Rp. <?= $invoice['nama'] ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-center">Harga Total</th>
                        <th>Rp. <?= number_format($invoice['AmountPaid'], 0, ',', '.') ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mt-3">Kembali</a>
</main>

<?= $this->include('template/footer2') ?>