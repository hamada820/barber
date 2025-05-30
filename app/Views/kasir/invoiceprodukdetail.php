<?php
$title = "Detail Invoice Produk #" . esc($id_invoiceproduk);
?>

<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>

<main class="flex-grow-1 p-4">
    <h1><?= $title ?></h1>

    <div class="text-center mb-4">
        <img src="<?= base_url('assets/img/logokharisma.png') ?>" alt="Logo" width="170" />
    </div>

    <!-- Detail Produk yang Dibeli -->
    <div class="card mb-3">
        <div class="card-header bg-success text-white">Detail Pembelian Produk</div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($item['nama_produk']) ?></td>
                            <td>Rp. <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td><?= esc($item['jumlah']) ?></td>
                            <td>Rp. <?= number_format($item['total'], 0, ',', '.') ?></td>
                            <td><?= ucfirst($item['status']) ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($item['tanggal'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <th colspan="4" class="text-center">Total Keseluruhan</th>
                        <th colspan="3">Rp. <?= number_format($item['total'], 0, ',', '.') ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="<?= base_url('kasir/invoice-produk') ?>" class="btn btn-secondary mt-3">Kembali</a>
</main>

<?= $this->include('template/footer2') ?>
