<?php
// Pastikan session sudah aktif
$session = session();

// Ambil data user dari session (atau bisa juga dari data yang dikirim controller)
$username = $session->get('username') ?? 'Guest';
$role = $session->get('role') ?? 'Unknown';

?>

<div class="profile-section container mt-5">
    <h3>Profil Member</h3>
    <div class="card" style="max-width: 400px;">
        <div class="card-body">
            <p><strong>Username:</strong> <?= esc($username) ?></p>
            <p><strong>Role:</strong> <?= esc($role) ?></p>
            <p><strong>Email:</strong> <?= esc($email) ?></p>
            <p><strong>Nomor Telepon:</strong> <?= esc($phone) ?></p>
            <!-- Tambahkan data profil lain sesuai kebutuhan -->

            <a href="<?= base_url('member/edit-profile') ?>" class="btn btn-primary btn-sm">Edit Profil</a>
        </div>
    </div>
</div>
