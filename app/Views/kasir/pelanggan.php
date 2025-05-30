<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <h1>Data Pelanggan</h1>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama / Username</th>
                            <th>No.HP</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($users as $user): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($user['username']) ?></td>
                            <td><?= esc($user['number']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td class="text-center"><?= date('d-m-Y', strtotime($user['RegDate'])) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('kasir/assign/' . $user['id_user']) ?>" class="btn btn-success btn-sm">
                                    Assign
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?= $this->include('template/footer2') ?>
