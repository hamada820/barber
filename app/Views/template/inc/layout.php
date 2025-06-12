<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Kharisma Barbershop' ?></title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <!-- Seharusnya hanya satu versi bootstrap -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> -->

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
</head>

<body>

  <?= $this->include('template/inc/header') ?>

  <?= $this->renderSection('content') ?>

  <!-- Kirim data aboutData ke footer -->
  <?= view('template/inc/footer', ['aboutData' => $aboutData ?? []]) ?>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Jangan include bootstrap bundle dua kali -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

  <script src="<?= base_url('assets/js/script.js') ?>"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    feather.replace();
  </script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <!-- Hapus duplicate renderSection('content') -->
  <!-- <?= $this->renderSection('content') ?> -->

</body>

</html>