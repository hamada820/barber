<?php
$session = session();
$username = $session->get('username') ?? 'Guest';
$role = $session->get('role') ?? 'Unknown';
$id_user = $session->get('id_user'); // Pastikan id_user disimpan di session

// Jika berasal dari controller, bisa juga: $user = $userModel->find($id_user);
?>

<div class="container mt-5">
    <h3>Profil Member</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card" style="max-width: 500px;">
        <div class="card-body">
            <!-- Form Edit -->
            <form method="post" action="<?= base_url('update-profile') ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= esc(session('username')) ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= esc(session('email')) ?>">
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Nomor Telepon</label>
                    <input type="text" name="number" id="number" class="form-control" value="<?= esc(session('number')) ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= base_url('member/dashboard') ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>