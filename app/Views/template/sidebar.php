<!-- Sidebar -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('kasir'); ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Tambahkan menu lainnya sesuai kebutuhan -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('absen'); ?>">
                <i class="bi bi-people"></i>
                <span>Absen</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('kasir/booking'); ?>">
                <i class="bi bi-people"></i>
                <span>Booking</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('kasir/pelanggan'); ?>">
                <i class="bi bi-people"></i>
                <span>Daftar Pelanggan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('kasir/nonpelanggan'); ?>">
                <i class="bi bi-people"></i>
                <span>Daftar Non-Pelanggan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('kasir/riwayat') ?>">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('kasir/invoices'); ?>">
                <i class="bi bi-envelope"></i>
                <span>Invoices</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('kasir/kelola_pembelian'); ?>">
                <i class="bi bi-cash-coin"></i>
                <span>Transaksi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('kasir/invoice-produk') ?>">
                <i class="bi bi-envelope"></i>
                <span>Invoices produk</span>
            </a>
        </li>


    </ul>
</aside>
<!-- End Sidebar -->