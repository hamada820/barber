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
<!-- Footer -->
<footer id="footer" class="footer">
  <div class="copyright">
    &copy; <?= date('Y'); ?> <strong><span>Kasir Area</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    Developed by <a href="#">Hamada | Dev</a>
  </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Vendor JS Files -->
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>

</body>

</html>