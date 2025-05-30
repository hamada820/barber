<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\PegawaiModel;
use App\Models\PageModel;
use App\Models\ProductModel;

class Home extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function index()
{
    $serviceModel = new ServiceModel();
    $pegawaiModel = new PegawaiModel();
    $productModel = new ProductModel();

    $services = $serviceModel->findAll();
    $pegawai = $pegawaiModel->findAll();
    $products = $productModel->findAll();
    $page = $this->pageModel->findAll();
    $aboutData = $this->pageModel
        ->where('PageType', 'aboutus')
        ->first(); // ambil satu data saja


    return view('free/home', [
        'services' => $services,
        'pegawai' => $pegawai,
        'products' => $products,
        'page' => $page,
        'aboutData' => $aboutData
    ]);
}


    public function kirim()
    {
        helper(['form', 'url']);

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'pesan' => 'required|min_length[10]|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Form tidak valid. Harap isi dengan benar.');
        }

        $nama = $this->request->getPost('name');
        $emailPengirim = $this->request->getPost('email');
        $pesan = $this->request->getPost('pesan');

        $email = \Config\Services::email();
        $email->setFrom($emailPengirim, $nama);
        $email->setTo('facelldill999@gmail.com'); // ganti dengan email penerima
        $email->setSubject('Kritik dan Saran dari Free User');

        $body = "
            <h3>Kritik dan Saran</h3>
            <p><strong>Nama:</strong> {$nama}</p>
            <p><strong>Email:</strong> {$emailPengirim}</p>
            <p><strong>Pesan:</strong><br>{$pesan}</p>
        ";

        $email->setMessage($body);

        if ($email->send()) {
            return redirect()->back()->with('success', 'Pesan berhasil dikirim. Terima kasih atas masukannya!');
        } else {
            return redirect()->back()
                ->with('error', 'Gagal mengirim pesan.')
                ->with('debug', $email->printDebugger(['headers']));
        }
    }
}
