<section class="footer bg-theme ps-3 pe-3 mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <span id="about"></span>

      </div>

      <div class="col-md-2 mb-3">
        <h6 class="fw-bold">Tautan Langsung</h6>
        <ul class="list-unstyled">
          <li class="pb-2"><a href="#contact" class="text-muted text-decoration-none">Kontak</a></li>
          <li class="pb-2"><a href="#faq" class="text-muted text-decoration-none">F.A.Q</a></li>
          <li class="pb-2"><a href="#location" class="text-muted text-decoration-none">Lokasi</a></li>
        </ul>
      </div>

      <div class="col-md-2 mb-3">
        <h6 class="fw-bold">Beberapa Tautan</h6>
        <ul class="list-unstyled">
          <li class="pb-2"><a href="<?= base_url('cookie-policy') ?>" class="text-muted text-decoration-none">Cookie Policy</a></li>
          <li class="pb-2"><a href="<?= base_url('support') ?>" class="text-muted text-decoration-none">Support</a></li>
        </ul>
      </div>

      <div class="col-md-3">
        <h6 class="fw-bold">Office</h6>
        <address class="text-muted">
          <a href="mailto:kharismabarbershop@gmail.com" class="text-muted">kharismabarbershop@gmail.com</a><br>
          Indonesia, Earth
        </address>
      </div>
    </div>

    <hr>

    <p class="text-center mt-2 mb-0">
      &copy; <strong><?= date('Y'); ?></strong> All rights reserved | Hamada
    </p>
  </div>
</section>
<div class="modal fade" id="modalProfil" tabindex="-1" aria-labelledby="modalProfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalProfilLabel">Profil Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <?= view('template/inc/profile-section') ?>
      </div>
    </div>
  </div>
</div>