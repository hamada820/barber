<section class="footer bg-theme ps-3 pe-3 mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <span id='about'></span>
        <?php if (!empty($aboutData)): ?>
  <?php foreach ($aboutData as $row): ?>
    <img src="<?= base_url('assets/img/logokharisma.png') ?>" width="71" alt="Logo Kharisma Barbershop"> 
    <span class="fw-bold"><?= esc($row['PageTitle']) ?></span>
    <p class="text-muted"><?= esc($row['PageDescription']) ?></p>
  <?php endforeach; ?>
<?php endif; ?>

      </div>

      <div class="col-md-2 mb-3">
        <h6 class="fw-bold">Tautan Langsung</h6>
        <ul class="list-group list-unstyled">
          <li class="pb-2"><a href="#contact" class="text-muted text-decoration-none">Kontak</a></li>
          <li class="pb-2"><a href="#faq" class="text-muted text-decoration-none">F.A.Q</a></li>
          <li class="pb-2"><a href="#location" class="text-muted text-decoration-none">Lokasi</a></li>
        </ul>
      </div>

      <div class="col-md-2 mb-3">
        <h6 class="fw-bold">Beberapa Tautan</h6>
        <ul class="list-group list-unstyled">
          <li class="pb-2"><a href="<?= base_url('cookie-policy') ?>" class="text-muted text-decoration-none">Cookie Policy</a></li>
          <li class="pb-2"><a href="<?= base_url('support') ?>" class="text-muted text-decoration-none">Support</a></li>
        </ul>
      </div>

      <div class="col-md-2">
        <h6 class="fw-bold">Office</h6>
        <address class="text-muted">
          <a href="mailto:kharismabarbershop@gmail.com">kharismabarbershop@gmail.com</a><br>
          Indonesia, Earth
        </address>
      </div>
    </div>

    <hr>

    <p class="text-center mt-2">
      Copyright &copy;
      <strong><?= date('Y'); ?></strong> All rights reserved | F.R.
    </p>
  </div>
</section>
