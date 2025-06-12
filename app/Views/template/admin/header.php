<?php
$session = session();

if (!$session->get('logged_in')) {
  return redirect()->to('/login?info=Login Terlebih Dahulu!')->send();
  exit;
}
helper('url');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard - Admin Area</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/logokharisma.png'); ?>" />
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css'); ?>" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets/css/style2.css'); ?>" rel="stylesheet">
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="<?= base_url('index'); ?>" class="logo d-flex align-items-center">
        <img src="<?= base_url('assets/img/logokharisma.png'); ?>" alt="Logo">&nbsp;
        <span class="d-none d-lg-block">Admin Area</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" id="searchInput" class="form-control" placeholder="Search for keyword..." title="Enter search keyword">
      </form>
    </div>
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle" href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>

        <!-- Profile -->
        <li class="nav-item dropdown pe-3">
  <a href="#" class="nav-link nav-profile d-flex align-items-center pe-0" data-bs-toggle="dropdown">
    <i class="bi bi-person-circle me-2"></i>
    <span class="d-none d-md-block dropdown-toggle ps-2"><?= session()->get('username'); ?></span>
  </a>
  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
    <li class="dropdown-header">
      <h6><?= session()->get('username'); ?></h6>
      <span>Kharisma | Barbershop</span>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li>
      <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#modalProfil">
        <i class="bi bi-person"></i>
        <span>Profil</span>
      </a>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li>
      <a class="dropdown-item d-flex align-items-center" href="<?= base_url('/logout'); ?>" onClick="return confirm('Kamu yakin untuk logout?')">
        <i class="bi bi-box-arrow-right"></i>
        <span>Sign Out</span>
      </a>
    </li>
  </ul>
</li>

      </ul>
    </nav>
  </header>
  <!-- End Header -->