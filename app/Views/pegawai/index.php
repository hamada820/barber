<?= $this->include('template/pegawai/header') ?>
<?= $this->include('template/pegawai/sidebar') ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Total | Layanan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-knife bx-flip-horizontal bx-tada'></i>
                            </div>
                            <div class="ps-3">
                                <h6><?= $totalServices ?></h6>
                                <span class="text-success small pt-1 fw-bold">Total Layanan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-md-6">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah | Pelanggan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bxs-user bx-tada'></i>
                            </div>
                            <div class="ps-3">
                                <h6><?= $totalUsers ?></h6>
                                <span class="text-success small pt-1 fw-bold">Total Pelanggan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->include('template/pegawai/footer') ?>
