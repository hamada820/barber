<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('admin') ?>">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <!-- Data Absensi -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url('admin/absen') ?>">
        <i class="bi bi-menu-button-wide"></i>
        <span>Data Absen</span>
      </a>
    </li>

    <!-- Service -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#service-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Service</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="service-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?= base_url('admin/addservice') ?>">
            <i class="bi bi-circle"></i><span>Add Service</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin/services') ?>">
            <i class="bi bi-circle"></i><span>Manage Service</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- Product -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#product-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Product</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="product-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?= base_url('admin/addproduct') ?>">
            <i class="bi bi-circle"></i><span>Add Product</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin/products') ?>">
            <i class="bi bi-circle"></i><span>Manage Product</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- Pegawai -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#pegawai-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Pegawai</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="pegawai-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?= base_url('admin/tambahPegawai') ?>">
            <i class="bi bi-circle"></i><span>Add Pegawai</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin/pegawai') ?>">
            <i class="bi bi-circle"></i><span>Manage Pegawai</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- Pages -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#pages-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-calculator"></i><span>Pages</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="pages-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?= base_url('admin/editabout') ?>">
            <i class="bi bi-circle"></i><span>About Us</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin/editlokasi') ?>">
            <i class="bi bi-circle"></i><span>Location</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- Customer List -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url('admin/memberList') ?>">
        <i class="bi bi-card-list"></i>
        <span>Member List</span>
      </a>
    </li>

    <!-- Invoices -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url('admin/invoices') ?>">
        <i class="bi bi-calculator"></i>
        <span>Invoices</span>
      </a>
    </li>

    <!-- Invoices -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url('admin/invoice-produk') ?>">
        <i class="bi bi-calculator"></i>
        <span>Invoices produk</span>
      </a>
    </li>
    

    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url('admin/laporan') ?>">
        <i class="bi bi-file-earmark-bar-graph"></i>
        <span>Laporan</span>
      </a>
    </li>

    <!-- Blank Page -->

</aside>
<!-- End Sidebar -->
