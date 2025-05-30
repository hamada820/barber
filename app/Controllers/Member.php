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
        $discount = $bookingModel->where('id_user', session('id_user'))->countAll();
        if ($discount >= 9) {
            if ($id_service == 29) {
                $bookingModel->insert([
                    'id_pegawai'      => NULL,
                    'id_user'      => $id_user,
                    'id_service'   => $id_service,
                    'jumlah'       => $jumlah,
                    'total'        => 50000,
                    'status'       => 'Menunggu',
                    'tanggal'      => $this->request->getPost('tanggal'),
                ]);
                return redirect()->back()->with('success', 'Permintaan layanan berhasil dikirim, tunggu persetujuan admin.');
            }
        }
        $bookingModel->insert([
            'id_pegawai'      => NULL,
            'id_user'      => $id_user,
            'id_service'   => $id_service,
            'jumlah'       => $jumlah,
            'total'        => $total,
            'status'       => 'Menunggu',
            'tanggal'      => $this->request->getPost('tanggal'),
        ]);

        return redirect()->back()->with('success', 'Permintaan layanan berhasil dikirim, tunggu persetujuan admin.');
    }
}
