<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Invoice #<?= esc($invoice['id_invoice']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

   <div class="text-center">
<img src="data:image/png;base64,<?= $logoBase64 ?>" width="170" alt="Logo" />
    <h2>Detail Invoice #<?= esc($invoice['id_invoice']) ?></h2>
</div>


    <h4>Services Details</h4>
    <table>
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
            <tr>
                <td>1</td>
                <td><?= esc($invoice['ServiceName']) ?></td>
                <td>Rp. <?= number_format($invoice['Cost'], 0, ',', '.') ?></td>
                <td>Rp. <?= number_format($invoice['AmountPaid'], 0, ',', '.') ?></td>
                <td><?= esc($invoice['nama']) ?></td>
            </tr>
            <tr>
                <th colspan="3" class="text-center">Harga Total</th>
                <th colspan="2">Rp. <?= number_format($invoice['AmountPaid'], 0, ',', '.') ?></th>
            </tr>
        </tbody>
    </table>

    <p class="text-center"><strong>Terima kasih telah berkunjung ke barbershop kami!</strong></p>

</body>
</html>
