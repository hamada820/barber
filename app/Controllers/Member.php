<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\HistoryModel;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\ServiceModel;
use App\Models\PembelianModel;
use App\Models\Booking;

class Member extends BaseController
{
    public $riwayatModel;
    public function __construct()
    {
        $this->riwayatModel = new HistoryModel();
    }
    public function dashboard()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'Member') {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }

        $userId = $session->get('id_user');

        $invoiceModel = new InvoiceModel();
        $bookModel = new Booking();
        $historyModel = new HistoryModel();
        $servicesModel = new ServiceModel();
        $userModel = new UserModel();
        $productModel = new ProductModel(); // Tambahkan model produk

        // Ambil invoice milik user
        $invoices = $invoiceModel->where('id_user', $userId)
            ->orderBy('PostingDate', 'DESC')
            ->findAll();

        // Ambil riwayat pemotongan milik user
        $histories = $historyModel->getUserHistoryWithPegawai($userId);

        // Ambil data user (username, email, nomor hp)
        $user = $userModel->find($userId);

        // Ambil semua produk yang tersedia
        $products = $productModel->findAll();

        $data = [
            'booked'  => $bookModel->where('booking.id_user', session('id_user'))
                ->join('tblpegawai', 'tblpegawai.id_pegawai = booking.id_pegawai', 'left')
                ->join('tblservices', 'tblservices.id_service = booking.id_service')->findAll(),
            'invoices'  => $invoices,
            'histories' => $histories,
            'services'  => $servicesModel->where('bookable', true)->findAll(),
            'products'  => $products,
            'username'  => $user['username'] ?? '',
            'email'     => $user['email'] ?? '',
            'phone'     => $user['number'] ?? '', // pastikan kolomnya benar
            'role'      => $user['role'] ?? '',
        ];
        // var_dump($data['booked']);
        // die;
        return view('member/index', $data);
    }
    public function beliProduk()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'Member') {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }

        $id_produk = $this->request->getPost('id_produk');
        $jumlah = $this->request->getPost('jumlah');
        $id_user = $session->get('id_user');

        $productModel = new ProductModel();
        $produk = $productModel->find($id_produk);

        if (!$produk || $jumlah > $produk['stok']) {
            return redirect()->back()->with('error', 'Pembelian gagal! Produk tidak valid atau stok kurang.');
        }

        $total = $jumlah * $produk['harga'];

        $pembelianModel = new PembelianModel();
        $pembelianModel->insert([
            'id_user'    => $id_user,
            'id_produk'  => $id_produk,
            'jumlah'     => $jumlah,
            'total'      => $total,
            'status'     => 'Menunggu',
            'tanggal'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Permintaan pembelian berhasil dikirim, tunggu persetujuan admin.');
    }
    public function beliLayanan()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'Member') {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }

        $id_service = $this->request->getPost('id_service');
        $id_user = $session->get('id_user');

        // Ambil data layanan
        $serviceModel = new ServiceModel();
        $layanan = $serviceModel->find($id_service);

        $tanggal = $this->request->getPost('tanggal');
        if (!$tanggal || strtotime($tanggal) < time()) {
            return redirect()->back()->with('error', 'Tanggal booking tidak valid. Harus setelah waktu sekarang.');
        }
        if (!$layanan) {
            return redirect()->back()->with('error', 'Layanan tidak ditemukan!');
        }

        $jumlah = 1;
        $total = $jumlah * $layanan['Cost'];

        $bookingModel = new Booking();
        $discount = $this->riwayatModel->where('id_user', $id_user)->countAll();
        // Jika user sudah booking 9x → promo
        if ($discount >= 9) {
            // Insert booking tanpa harga (promo)
            $bookingModel->insert([
                'id_pegawai' => NULL,
                'id_user'    => $id_user,
                'id_service' => $id_service,
                'status'     => 'Menunggu',
                'tanggal'    => $tanggal
            ]);

            // Ambil data user untuk email
            $userModel = new \App\Models\UserModel(); // ganti sesuai model user
            $user = $userModel->find($id_user);

            if ($user && !empty($user['email'])) {
                $emailService = \Config\Services::email();
                $emailService->setFrom('kharismabarbershp@gmail.com', 'Kharisma Barbershop');
                $emailService->setTo($user['email']);
                $emailService->setSubject('Selamat! Anda Mendapatkan Promo Member');

                $message = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
                    .container { max-width: 600px; margin: 30px auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                    h2 { color: #333; }
                    p { font-size: 16px; color: #555; line-height: 1.6; }
                    .footer { font-size: 12px; color: #aaa; margin-top: 30px; text-align: center; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Selamat, {$user['username']}!</h2>
                    <p>Anda telah melakukan <strong>" . $discount . "</strong> booking di <strong>Kharisma Barbershop</strong>.</p>
                    <p>Sebagai bentuk apresiasi, Anda mendapatkan <strong>promo potongan harga layanan</strong> untuk kunjungan berikutnya.</p>
                    <p>Tunjukkan email ini kepada kasir saat Anda datang.</p>
                    <p><strong>Layanan:</strong> {$layanan['ServiceName']}</p>
                    <p><strong>Tanggal Booking:</strong> {$tanggal}</p>
                    <div class='footer'>&copy; " . date('Y') . " Kharisma Barbershop. All rights reserved.</div>
                </div>
            </body>
            </html>";

                $emailService->setMessage($message);
                $emailService->setMailType('html');

                if (!$emailService->send()) {
                    log_message('error', 'Gagal mengirim email ke ' . $user['email'] . '. Debug: ' . print_r($emailService->printDebugger(['headers', 'subject']), true));
                } else {
                    log_message('info', 'Email promo berhasil dikirim ke ' . $user['email']);
                }
            }

            return redirect()->back()->with('success', 'Selamat! Anda mendapat promo potongan harga. Tunjukkan email ini ke kasir saat datang.');
        }
        // Booking biasa (belum dapat promo)
        $bookingModel->insert([
            'id_pegawai' => NULL,
            'id_user'    => $id_user,
            'id_service' => $id_service,
            'total'      => $total,
            'status'     => 'Menunggu',
            'tanggal'    => $tanggal
        ]);

        return redirect()->back()->with('success', 'Permintaan layanan berhasil dikirim, tunggu persetujuan admin.');
    }

    public function invoiceHistory($id)
    {
        $invoiceModel = new \App\Models\InvoiceModel();

        // Ambil semua invoice milik member
        $invoices = $invoiceModel->where('id_user', $id)->findAll();

        $data = ['invoices' => $invoices];

        // Cek apakah ada invoiceid di URL
        $invoiceId = $this->request->getGet('invoiceid');
        if ($invoiceId) {
            $invoiceDetail = $invoiceModel
                ->join('tblpegawai', 'tblpegawai.id_pegawai = tblinvoice.id_pegawai')
                ->join('tblservices', 'tblservices.id_service = tblinvoice.id_service')
                ->where('tblinvoice.id_invoice', $invoiceId)
                ->first();

            if ($invoiceDetail) {
                $data['invoiceDetail'] = $invoiceDetail;
            }
        }

        return view('member/index', $data);
    }
}
