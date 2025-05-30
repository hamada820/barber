<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - MAsukkan Akun</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/logokharisma.png') ?>" />

  <!-- AOS & Feather Icons -->
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>

<!-- Login Start -->
<div class="container">
  <div class="row">
    <div class="mx-auto mt-5 text-center">
      <img src="<?= base_url('assets/img/logokharisma.png') ?>" width="71" alt="Logo Barber" />
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-7 mt-3 text-center">
      <img src="<?= base_url('assets/img/login.svg') ?>" class="img-fluid" width="550" alt="Login Image" />
    </div>

    <div class="col-md-5 mt-3">
      <div class="card shadow-sm p-3">
        <div class="card-body">
          <h4 class="text-center">Masukkan Akun</h4>

          <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger text-center" role="alert">
              <?= session()->getFlashdata('error') ?>
            </div>
          <?php endif; ?>

          <form class="mt-4" method="post" action="<?= base_url('login') ?>">
            <div class="form-group">
              <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" required />
            </div>

            <div class="form-group mt-3">
              <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required />
            </div>

            <div class="d-grid gap-2 mt-4">
              <button class="btn btn-color-theme" type="submit">Login</button>
              <p class="text-center mt-2">
                <a href="<?= base_url('/') ?>" class="text-theme">Back to Home</a>
              </p>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- Login End -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script> feather.replace(); </script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script> AOS.init(); </script>

</body>
</html>
