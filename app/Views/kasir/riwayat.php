<?= $this->include('template/header2') ?>
<?= $this->include('template/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Riwayat Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Riwayat</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Pengguna Terdaftar</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama / Username</th>
                                        <th>No.HP</th>
                                        <th>Email</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php if (!empty($users)): ?>
    <?php $no = 1; foreach ($users as $user): ?>
    <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td><?= esc($user['username']) ?></td>
        <td><?= esc($user['number']) ?></td>
        <td><?= esc($user['email']) ?></td>
        <td class="text-center"><?= date('d-m-Y', strtotime($user['RegDate'])) ?></td>
        <td class="text-center">
            <a href="<?= base_url('kasir/riwayat/detail/' . $user['id_user']) ?>" class="btn btn-sm btn-primary">
                More
            </a>
        </td>
    </tr>
    <?php endforeach; ?>


                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada data pengguna.</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div> <!-- col -->
        </div> <!-- row -->
    </section>
</main>

<?= $this->include('template/footer2') ?>
