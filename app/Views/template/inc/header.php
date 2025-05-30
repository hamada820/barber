<nav class="navbar navbar-expand-lg navbar-light bg-light p-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= base_url('/') ?>">
      <img src="<?= base_url('assets/img/logokharisma.png') ?>" alt="Logo" width="71">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
        <a href="<?= base_url('/') ?>" class="nav-link btn btn-outline-theme ps-3 pe-3">Home</a>
        <a href="#Invoices" class="nav-link btn btn-outline-theme ps-3 pe-3">Invoice</a>
        <a href="#Hsitory" class="nav-link btn btn-outline-theme ps-3 pe-3">History</a>
        <a href="#"class="nav-link btn btn-outline-theme ps-3 pe-3" data-bs-toggle="modal" data-bs-target="#modalProfil">Profil</a>


        <a href="<?= base_url('/logout') ?>" class="nav-link btn btn-outline-theme ps-3 pe-3">Logout</a>

       
      </div>
    </div>
  </div>
</nav>
