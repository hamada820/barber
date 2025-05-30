<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\UserModel;
use App\Models\HistoryModel;
use App\Models\PegawaiModel;
use CodeIgniter\Controller;

class pegawai extends BaseController
{
    protected $userModel;
    protected $layananModel;
    protected $pegawaiModel;
    protected $historyModel;

    public function __construct()
    {
        $this->userModel     = new UserModel();
        $this->layananModel  = new ServiceModel(); // nama modelmu untuk layanan
        $this->pegawaiModel  = new PegawaiModel(); // pastikan model ini sudah ada
        $this->historyModel  = new HistoryModel(); // pastikan model ini sudah ada
    }

    public function index()
    {
        $data = [
            'totalServices' => $this->layananModel->countAll(),
            'totalUsers'    => $this->userModel->countAll(),
        ];

        return view('pegawai/index', $data);
    }

    public function riwayat()
    {
        $data['users'] = $this->userModel->where('role', 'member')->findAll();
        return view('pegawai/riwayat', $data);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tblhistory');
        $builder->select('users.username, tblhistory.tanggal, tblinvoice.id_invoice, tblhistory.deskripsi, tblhistory.hasil, tblpegawai.nama AS capster, tblhistory.id_history');
        $builder->join('users', 'users.id_user = tblhistory.id_user');
        $builder->join('tblinvoice', 'tblinvoice.id_invoice = tblhistory.id_invoice', 'left');
        $builder->join('tblpegawai', 'tblpegawai.id_pegawai = tblhistory.id_pegawai');
        $builder->where('tblhistory.id_user', $id);
        $data['riwayat'] = $builder->get()->getResultArray();

        return view('pegawai/riwayat_detail', $data);
    }
    public function updateRiwayat($id_history)
    {
        $historyModel = new \App\Models\HistoryModel();
        $deskripsi = $this->request->getPost('deskripsi');
        $file = $this->request->getFile('hasil');

        $data = ['deskripsi' => $deskripsi];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/hasil/', $newName);
            $data['hasil'] = 'uploads/hasil/' . $newName;
        }

        $historyModel->update($id_history, $data);

        return redirect()->back()->with('success', 'Riwayat berhasil diperbarui.');
    }
}
