<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Invoice Produk - Kharisma Barbershop</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header img { max-width: 150px; }
        h2 { margin-bottom: 5px; }
        .invoice-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        tfoot td { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="data:image/png;base64,<?= $logoBase64 ?>" alt="Logo Kharisma Barbershop" />
        <h2>Invoice Produk</h2>
        <p>Tanggal: <?= esc($invoice['tanggal']) ?></p>
        <p>Nama: <?= esc($username) ?></p>
        <p>ID Invoice: <?= esc($invoice['id_invoice']) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan (Rp)</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($invoice['items'] as $item): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($item['nama_produk']) ?></td>
                    <td><?= esc($item['jumlah']) ?></td>
                    <td><?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= number_format($item['total'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right">Total Bayar</td>
                <td>Rp <?= number_format($invoice['total'], 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <p>Terima kasih telah berbelanja di Kharisma Barbershop!</p>
</body>
</html>
