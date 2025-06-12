<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmailVerificationModel;
use CodeIgniter\Controller;
use Config\Services;

class Auth extends BaseController
{
  public $usersModel;
  public function __construct()
  {
    $this->usersModel = new UserModel();
  }
  public function login()
  {
    if (session('logged_in')) {
      if (session('role') == 'Admin') {
        return redirect()->to(base_url('/admin'));
      } elseif (session('role') == 'Kasir') {
        return redirect()->to(base_url('/kasir'));
      } elseif (session('role') == 'Member') {
        return redirect()->to(base_url('/member/dashboard'));
      }
    }
    return view('auth/login'); // views/auth/login.php
  }

  public function dologin()
  {
    $userModel = new UserModel();
    $session = session();

    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $user = $userModel->where('username', $username)->first();

    if ($user && password_verify($password, $user['password'])) {
      if ($user['is_active'] == 0) {
        return redirect()->back()->with('error', 'Akun belum aktif. Silakan cek email Anda untuk verifikasi.');
      }

      $session->set([
        'id_user'   => $user['id_user'],
        'email'  => $user['email'],
        'number'  => $user['number'],
        'username'  => $user['username'],
        'role'      => $user['role'],
        'logged_in' => true
      ]);
      switch ($user['role']) {
        case 'Admin':
          return redirect()->to('/admin');
        case 'Kasir':
          return redirect()->to('/kasir');
        case 'Pegawai':
          return redirect()->to('/pegawai');
        case 'Member':
          return redirect()->to('/member/dashboard');
        default:
          return redirect()->to('/');
      }
    }

    return redirect()->back()->with('error', 'Username atau password salah!');
  }

  public function logout()
  {
    session()->destroy();
    return redirect()->to(base_url('/'));
  }

  public function register()
  {
    return view('auth/register');
  }

  public function registerProcess()
  {
    $userModel = new UserModel();
    $emailVerifModel = new EmailVerificationModel();

    // Validasi input
    if (!$this->validate([
      'username' => 'required',
      'number'   => 'required',
      'email'    => 'required|valid_email|is_unique[users.email]',
      'password' => 'required|min_length[6]'
    ])) {
      return redirect()->back()->withInput()->with('error', 'Data tidak valid atau email sudah digunakan.');
    }

    $username = $this->request->getPost('username');
    $number   = $this->request->getPost('number');
    $email    = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // Simpan user dengan status belum aktif
    $userModel->save([
      'username'  => $username,
      'number'    => $number,
      'email'     => $email,
      'password'  => password_hash($password, PASSWORD_DEFAULT),
      'RegDate'   => date('Y-m-d H:i:s'),
      'is_active' => 0,
      'role'      => 'member'
    ]);

    // Buat token verifikasi
    $token = bin2hex(random_bytes(16));
    $emailVerifModel->insert([
      'email' => $email,
      'token' => $token
    ]);

    // Kirim email verifikasi
    // Kirim email verifikasi
    // Kirim email verifikasi
    $emailService = Services::email();
    $emailService->setFrom('kharismabarbershp@gmail.com', 'Kharisma Barbershop');
    $emailService->setTo($email);
    $emailService->setSubject('Aktivasi Akun Anda di Kharisma Barbershop');


    $message = "
<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    h2 {
      color: #333;
    }
    p {
      font-size: 16px;
      color: #555;
      line-height: 1.6;
    }
    .button {
      display: inline-block;
      padding: 12px 24px;
      margin-top: 20px;
      font-size: 16px;
      color: #ffffff;
      background-color: #28a745;
      text-decoration: none;
      border-radius: 5px;
    }
    .footer {
      font-size: 12px;
      color: #aaa;
      margin-top: 30px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class='container'>
    <h2>Verifikasi Email Anda</h2>
    <p>Halo <strong>$username</strong>,</p>
    <p>Terima kasih telah mendaftar di <strong>Kharisma Barbershop</strong>.</p>
    <p>Silakan klik tombol di bawah ini untuk mengaktifkan akun Anda:</p>
    <a href='" . base_url("verify?email=$email&token=$token") . "' class='button'>Aktifkan Akun</a>
    <p>Jika Anda tidak merasa mendaftar, abaikan email ini.</p>
    <div class='footer'>
      &copy; " . date('Y') . " Kharisma Barbershop. All rights reserved.
    </div>
  </div>
</body>
</html>
";

    $emailService->setMessage($message);
    $emailService->setMailType('html');

    if (!$emailService->send()) {
      $error = $emailService->printDebugger(['headers', 'subject']);
      return redirect()->to('/register')->with('error', 'Gagal mengirim email verifikasi: ' . $error);
    } else {
      log_message('info', 'Email berhasil dikirim ke ' . $email);
    }
  }

  public function verify()
  {
    $email = $this->request->getGet('email');
    $token = $this->request->getGet('token');

    $userModel = new UserModel();
    $verifModel = new EmailVerificationModel();

    $verifData = $verifModel->where('email', $email)->where('token', $token)->first();

    if ($verifData) {
      $userModel->where('email', $email)->set(['is_active' => 1])->update();
      $verifModel->where('email', $email)->delete();
      return redirect()->to('/login')->with('success', 'Akun berhasil diaktifkan! Silakan login.');
    } else {
      return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa.');
    }
  }
  public function profileUpdate()
  {
    $id_user = session('id_user');

    // Ambil inputan
    $data = [
      'username' => $this->request->getPost('username'),
      'number'   => $this->request->getPost('number'),
      'email'    => $this->request->getPost('email'),
    ];

    // Jika password tidak kosong, update juga password-nya
    $password = $this->request->getPost('password');
    if (!empty($password)) {
      $data['password'] = password_hash($password, PASSWORD_BCRYPT);
    }

    // Update ke database
    $updated = $this->usersModel->update($id_user, $data);

    if ($updated) {
      // Update session jika username berubah
      session()->set('username', $data['username']);

      return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    } else {
      return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }
  }
}
