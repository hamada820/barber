<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\PegawaiModel;
use App\Models\ServiceModel;
use App\Models\HistoryModel;
use App\Models\ProductModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceProduk;
use App\Models\PageModel;
use App\Models\PembelianModel;
use App\Models\Absen;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Admin extends BaseController
{
    protected $userModel;
    protected $pegawaiModel;
    protected $serviceModel;
    protected $historyModel;
    protected $productModel;
    protected $invoiceModel;
    protected $pageModel; // <--- perbaiki di sini
    protected $pembelianModel;
    protected $invoiceProdukModel;
    protected $absenModel;



    public function __construct()
    {
        $this->userModel     = new UserModel();
        $this->pegawaiModel  = new PegawaiModel();
        $this->serviceModel  = new ServiceModel();
        $this->historyModel  = new HistoryModel();
        $this->productModel  = new ProductModel();
        $this->invoiceModel  = new InvoiceModel();
        $this->absenModel  = new Absen();
        $this->pageModel     = new PageModel(); // <--- konsisten
        $this->pembelianModel     = new PembelianModel(); // <--- konsisten
        $this->invoiceProdukModel     = new InvoiceProduk(); // <--- konsisten
    }

    public function index()
    {
        $data = [
            'totalServices' => $this->serviceModel->countAll(),
            'totalUsers'    => $this->userModel->countAll(),
        ];

        return view('admin/index', $data);
    }

    // Halaman menampilkan semua layanan (listing)
    public function services()
    {
        $data = [
            'services' => $this->serviceModel->orderBy('CreationDate', 'DESC')->findAll(),
        ];

        return view('admin/service', $data);
    }
    // Halaman tambah layanan (form + proses)
    public function addService()
    {
        // Menampilkan view form tambah layanan
        return view('admin/addservice');
    }

    public function storeService()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'ServiceName'        => 'required|min_length[3]|max_length[255]',
            'ServiceDescription' => 'required|min_length[10]',
            'Cost'               => 'required|numeric',
            'Image'              => 'uploaded[Image]|is_image[Image]|max_size[Image,2048]'
        ];

        if (!$this->validate($rules)) {
            return view('admin/addservice', [
                'validation' => $this->validator
            ]);
        }

        $img = $this->request->getFile('Image');
        $newName = $img->getRandomName();

        if (!$img->isValid()) {
            return redirect()->back()->withInput()->with('info', 'Gagal upload gambar: ' . $img->getErrorString());
        }

        if (!$img->move(FCPATH . 'uploads/services', $newName)) {
            return redirect()->back()->withInput()->with('info', 'Gagal memindahkan file gambar.');
        }

        // Simpan data ke database
        $this->serviceModel->insert([
            'ServiceName'        => $this->request->getPost('ServiceName'),
            'ServiceDescription' => $this->request->getPost('ServiceDescription'),
            'Cost'               => $this->request->getPost('Cost'),
            'Image'              => $newName,
            'CreationDate'       => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/services')->with('info', 'Layanan berhasil ditambahkan.');
    }

    public function editService($id)
    {
        $service = $this->serviceModel->find($id);

        if (!$service) {
            return redirect()->to('/admin/services')->with('info', 'Layanan tidak ditemukan.');
        }

        return view('admin/editservice', [
            'service' => $service,
        ]);
    }

    public function updateService($id)
    {
        helper(['form', 'url']);

        $service = $this->serviceModel->find($id);
        if (!$service) {
            return redirect()->to('/admin/services')->with('info', 'Data layanan tidak ditemukan.');
        }

        $rules = [
            'ServiceName'        => 'required|min_length[3]|max_length[255]',
            'ServiceDescription' => 'required|min_length[10]',
            'Cost'               => 'required|numeric',
        ];

        if ($this->request->getFile('Image')->isValid() && !$this->request->getFile('Image')->hasMoved()) {
            $rules['Image'] = 'is_image[Image]|max_size[Image,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'ServiceName'        => $this->request->getPost('ServiceName'),
            'ServiceDescription' => $this->request->getPost('ServiceDescription'),
            'Cost'               => $this->request->getPost('Cost'),
        ];

        $img = $this->request->getFile('Image');
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/services', $newName);
            $data['Image'] = $newName;
        }

        $this->serviceModel->update($id, $data);
        return redirect()->to('/admin/services')->with('info', 'Layanan berhasil diperbarui.');
    }


    public function deleteService($id)
    {
        $layanan = $this->serviceModel->find($id);
        if ($layanan) {
            // Hapus gambar jika ada
            if (!empty($layanan['Image']) && file_exists(FCPATH . 'uploads/services/' . $layanan['Image'])) {
                unlink(FCPATH . 'uploads/services/' . $layanan['Image']);
            }

            $this->serviceModel->delete($id);
            return redirect()->to('/admin/services')->with('info', 'Layanan berhasil dihapus.');
        }

        return redirect()->to('/admin/services')->with('info', 'Layanan tidak ditemukan.');
    }




    //produk//
    // Menampilkan semua produk
    public function products()
    {
        $data = [
            'products' => $this->productModel->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('admin/products', $data);
    }

    // Menambahkan produk
    public function addProduct()
    {
        return view('admin/addproduct');
    }

    public function storeProduct()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_produk' => 'required|min_length[3]|max_length[255]',
            'deskripsi'   => 'required|min_length[10]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'Image'       => 'uploaded[Image]|is_image[Image]|max_size[Image,2048]'
        ];

        if (!$this->validate($rules)) {
            return view('admin/addproduct', [
                'validation' => $this->validator
            ]);
        }

        $img = $this->request->getFile('Image');
        $newName = $img->getRandomName();

        if (!$img->isValid()) {
            return redirect()->back()->withInput()->with('info', 'Gagal upload gambar: ' . $img->getErrorString());
        }

        if (!$img->move(FCPATH . 'uploads/products', $newName)) {
            return redirect()->back()->withInput()->with('info', 'Gagal memindahkan file gambar.');
        }

        $this->productModel->insert([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'Image'       => $newName,
        ]);

        return redirect()->to('/admin/products')->with('info', 'Produk berhasil ditambahkan.');
    }
    // Mengedit produk
    public function editProduct($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/products')->with('info', 'Produk tidak ditemukan.');
        }

        return view('admin/editproduct', [
            'product' => $product
        ]);
    }

    public function updateProduct($id)
    {
        $rules = [
            'nama_produk' => 'required|min_length[3]|max_length[255]',
            'deskripsi'   => 'required|min_length[10]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/products')->with('info', 'Produk tidak ditemukan.');
        }

        $data = [
            'id_produk'  => $id, // PENTING!
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
        ];

        $file = $this->request->getFile('Image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/products', $newName);
            $data['Image'] = $newName;

            // Hapus Image lama jika ada
            if (!empty($product['Image'])) {
                @unlink(FCPATH . 'uploads/products/' . $product['Image']);
            }
        }

        $this->productModel->save($data);
        return redirect()->to('/admin/products')->with('info', 'Produk berhasil diperbarui.');
    }
    // Menghapus produk
    public function deleteProduct($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/products')->with('info', 'Produk tidak ditemukan.');
        }

        if ($product['Image'] && file_exists(FCPATH . 'uploads/products/' . $product['Image'])) {
            unlink(FCPATH . 'uploads/products/' . $product['Image']);
        }

        $this->productModel->delete($id);
        return redirect()->to('/admin/products')->with('info', 'Produk berhasil dihapus.');
    }


    //member list
    public function memberList()
    {
        // Ambil user yang role-nya 'member' saja
        $data['users'] = $this->userModel->where('role', 'member')->findAll();

        return view('admin/memberlist', $data);
    }


    public function deleteUser($id)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/memberList')->with('info', 'User tidak ditemukan.');
        }
        $userModel->delete($id);
        return redirect()->to('/admin/memberList')->with('info', 'User berhasil dihapus.');
    }
    public function invoiceList()
    {
        $invoices = $this->invoiceModel
            ->select('tblinvoice.*, users.username, users.email, tblservices.ServiceName')
            ->join('users', 'users.id_user = tblinvoice.id_user', 'left')
            ->join('tblservices', 'tblservices.id_service = tblinvoice.id_service', 'left')
            ->findAll();

        return view('admin/invoices', [
            'invoices' => $invoices
        ]);
    }
    public function deleteInvoice($id)
    {
        $this->invoiceModel->delete($id);
        return redirect()->to('/admin/invoices')->with('info', 'Invoice berhasil dihapus.');
    }

    public function view($id_invoice = null)
    {
        // Mulai session
        //$session = session();

        // Cek session login
        // if (!$session->get('status') || $session->get('status') != 'login') {
        // return redirect()->to('/login?info=Login Terlebih Dahulu!');
        // }

        if ($id_invoice === null) {
            return redirect()->to('/admin/invoices')->with('error', 'Invoice ID tidak ditemukan');
        }

        // Load model
        $invoiceModel = new InvoiceModel();
        $pegawaiModel = new PegawaiModel();

        // Ambil data invoice berdasarkan id_invoice
        $invoiceData = $invoiceModel->join('tblpegawai', 'tblpegawai.id_pegawai = tblinvoice.id_pegawai')->join('tblservices', 'tblservices.id_service = tblinvoice.id_service')->where('tblinvoice.id_invoice', $id_invoice)->first();
        if (!$invoiceData) {
            return redirect()->to('admin/invoices')->with('error', 'Invoice tidak ditemukan');
        }

        // Ambil pegawai terkait invoice
        // $pegawaiData = $pegawaiModel->find($id_invoice);

        // Passing data ke view
        $data = [
            // 'session' => $session,
            'invoice' => $invoiceData,
            // 'pegawai' => $pegawaiData,
        ];

        return view('admin/view_invoices', $data);
    }

    //pegawai
    public function pegawai()
    {
        $data['pegawai'] = $this->pegawaiModel->findAll();
        return view('admin/pegawai', $data); // Sesuaikan dengan nama file view kamu
    }

    public function tambahPegawai()
    {
        return view('admin/tambah_pegawai');
    }

    public function simpanPegawai()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]',
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[Pegawai,Kasir]'
        ];

        if (!$this->validate($rules)) {
            return view('admin/tambah_pegawai', [
                'validation' => $this->validator,
            ]);
        }


        // Upload gambar
        $file = $this->request->getFile('image');
        $imageName = $file->getRandomName();
        $uploadPath = FCPATH . 'uploads/pegawai/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if (!$file->move($uploadPath, $imageName)) {
            return redirect()->back()->withInput()->with('errors', ['image' => 'Gagal upload gambar.']);
        }

        // Simpan data user
        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'is_active' => 1
        ];

        if (!$this->userModel->insert($userData)) {
            return redirect()->back()->withInput()->with('errors', ['user' => 'Gagal menyimpan data user.']);
        }

        $userId = $this->userModel->getInsertID();

        // Simpan data pegawai
        $pegawaiData = [
            'nama'     => $this->request->getPost('nama'),
            'alamat'   => $this->request->getPost('alamat'),
            'telepon'  => $this->request->getPost('telepon'),
            'image'    => $imageName,
            'id_user'  => $userId
        ];

        if (!$this->pegawaiModel->insert($pegawaiData)) {
            // rollback user jika pegawai gagal ditambah
            $this->userModel->delete($userId);
            return redirect()->back()->withInput()->with('errors', ['pegawai' => 'Gagal menyimpan data pegawai.']);
        }

        return redirect()->to('/admin/pegawai')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    // Form edit pegawai
    public function editPegawai($id_pegawai)
    {
        $pegawai = $this->pegawaiModel->find($id_pegawai);
        if (!$pegawai) {
            return redirect()->to('/admin/pegawai')->with('error', 'Data pegawai tidak ditemukan.');
        }
        $user = $this->userModel->find($pegawai['id_user']);
        $data = [
            'pegawai' => $pegawai,
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/edit_pegawai', $data);
    }

    // Proses update data pegawai
    public function updatePegawai($id_pegawai)
    {
        $pegawai = $this->pegawaiModel->find($id_pegawai);
        if (!$pegawai) {
            return redirect()->to('/admin/pegawai')->with('error', 'Data pegawai tidak ditemukan.');
        }
        $user = $this->userModel->find($pegawai['id_user']);
        if (!$user) {
            return redirect()->to('/admin/pegawai')->with('error', 'Data user tidak ditemukan.');
        }
        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'image' => 'max_size[image,2048]|is_image[image]', // optional upload
            'username' => 'required|is_unique[users.username,id_user,' . $user['id_user'] . ']',
            'email' => 'required|valid_email|is_unique[users.email,id_user,' . $user['id_user'] . ']',
            'password' => 'permit_empty|min_length[6]',
            'role' => 'required|in_list[Pegawai,Kasir]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
        // Update foto jika ada upload baru
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/pegawai/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $imageName);
            // Hapus file lama jika ada
            if ($pegawai['image'] && file_exists($uploadPath . $pegawai['image'])) {
                unlink($uploadPath . $pegawai['image']);
            }
        } else {
            $imageName = $pegawai['image']; // tetap pakai yang lama
        }
        // Update user data
        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role'),
            // Password hanya diupdate kalau ada input password baru
        ];
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->userModel->update($user['id_user'], $userData);
        // Update pegawai data
        $pegawaiData = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'image' => $imageName,
        ];
        $this->pegawaiModel->update($id_pegawai, $pegawaiData);
        return redirect()->to('/admin/pegawai')->with('success', 'Data pegawai berhasil diupdate.');
    }

    // Hapus pegawai dan user terkait
    public function hapusPegawai($id_pegawai)
    {
        $pegawai = $this->pegawaiModel->find($id_pegawai);
        if (!$pegawai) {
            return redirect()->to('/admin/pegawai')->with('error', 'Data pegawai tidak ditemukan.');
        }
        // Hapus foto jika ada
        $uploadPath = FCPATH . 'uploads/pegawai/';
        if ($pegawai['image'] && file_exists($uploadPath . $pegawai['image'])) {
            unlink($uploadPath . $pegawai['image']);
        }
        // Hapus user
        $this->userModel->delete($pegawai['id_user']);
        // Hapus pegawai
        $this->pegawaiModel->delete($id_pegawai);
        return redirect()->to('/admin/pegawai')->with('success', 'Data pegawai berhasil dihapus.');
    }



    public function editAbout()
    {
        $page = $this->pageModel->where('PageType', 'about')->first();

        if (!$page) {
            return redirect()->to('admin/pegawai')->with('error', 'Halaman About tidak ditemukan.');
        }

        return view('admin/edit_about', [
            'title' => 'Edit About Us',
            'page'  => $page
        ]);
    }


    public function updateAbout()
    {
        $id = $this->request->getPost('id');
        $updateData = [
            'PageTitle' => $this->request->getPost('title'),
            'PageDescription' => $this->request->getPost('description')
        ];
        $this->pageModel->update($id, $updateData);

        return redirect()->to('/admin/edit_about')->with('success', 'About Us berhasil diperbarui.');
    }


    public function editLocation()
    {
        $page = $this->pageModel->where('PageType', 'location')->first();

        if (!$page) {
            return redirect()->back()->with('error', 'Data halaman Lokasi tidak ditemukan.');
        }

        return view('admin/edit_lokasi', [
            'title' => 'Edit Lokasi Kami',
            'page' => $page
        ]);
    }
    public function updateLokasi()
    {
        $id = $this->request->getPost('id');
        $updateData = [
            'PageTitle' => $this->request->getPost('title'),
            'PageDescription' => $this->request->getPost('description')
        ];
        $this->pageModel->update($id, $updateData);

        return redirect()->to('/admin/edit_lokasi')->with('success', 'Informasi lokasi berhasil diperbarui.');
    }



    public function kelolaPembelian()
    {
        $model = new PembelianModel();
        $data['pembelian'] = $model->getPembelianDenganProdukDanUser(); // gabung produk dan user

        return view('admin/kelola_pembelian', $data);
    }

    public function setujuiPembelian($id_pembelian)
    {
        $pembelianModel = new PembelianModel();
        $produkModel = new ProductModel();
        $invoiceModel = new InvoiceModel();
        $db = \Config\Database::connect();

        // Ambil data pembelian
        $pembelian = $pembelianModel->where('id_pembelian', $id_pembelian)->first();
        if (!$pembelian) {
            return redirect()->back()->with('error', 'Data pembelian tidak ditemukan.');
        }

        // Ambil data produk
        $produk = $produkModel->find($pembelian['id_produk']);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Periksa stok cukup
        if ($produk['stok'] < $pembelian['jumlah']) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Update status pembelian
        $pembelianModel->update($id_pembelian, ['status' => 'disetujui']);

        // Kurangi stok produk
        $db->query('SET FOREIGN_KEY_CHECKS=0');
        $produkModel->update($produk['id_produk'], [
            'stok' => $produk['stok'] - $pembelian['jumlah']
        ]);

        // Buat BillingId unik
        $billingId = 'INV-' . strtoupper(uniqid());

        // Simpan ke invoice
        $res = $invoiceModel->insert([
            'id_user'     => $pembelian['id_user'],
            'id_service'  => $pembelian['id_produk'], // Gunakan id_produk karena dianggap sebagai layanan
            'BillingId'   => $billingId,
            'PostingDate' => date('Y-m-d H:i:s'),
            'AmountPaid'  => $pembelian['total']
        ]);
        $db->query('SET FOREIGN_KEY_CHECKS=1');

        return redirect()->back()->with('pesan', 'Pembelian disetujui dan invoice dibuat.');
    }


    public function tolakPembelian($id_pembelian)
    {
        $model = new \App\Models\PembelianModel();
        $model->update($id_pembelian, ['status' => 'ditolak']);
        return redirect()->back()->with('pesan', 'Pembelian ditolak.');
    }
    public function createInvoice()
    {
        $id_pembelian = $this->request->getPost('id_pembelian');
        $grandTotal = 0;
        foreach ($id_pembelian as $key) {
            $pembelian = $this->pembelianModel->find($key);
            $grandTotal += $pembelian['total'];
        }
        $invoiceProduk = $this->invoiceProdukModel->set('total', $grandTotal)->insert();
        if ($invoiceProduk) {
            foreach ($id_pembelian as $key) {
                $this->pembelianModel->where('id_pembelian', $key)->set('id_invoiceproduk', $this->invoiceProdukModel->getInsertID())->update();
            }
            return redirect()->to(base_url('admin/invoice-produk'));
        }
    }
    public function viewInvoice()
    {
        $data = [
            'data' => $this->invoiceProdukModel->findAll(),
        ];
        return view('admin/invoice-produk', $data);
    }
    public function detailInvoice($id)
    {
        $data = [
            'id_invoiceproduk' => $id,
            'data' => $this->pembelianModel->where('id_invoiceproduk', $id)->join('users', 'users.id_user = pembelian.id_user')->join('tblproduk', 'tblproduk.id_produk = pembelian.id_produk')->findAll(),
        ];
        return view('admin/invoiceprodukdetail', $data);
    }

    public function laporan()
    {
        $historyModel = new \App\Models\HistoryModel();

        $data['laporan'] = $historyModel->getLaporanPerPegawai();

        return view('admin/laporan', $data);
    }



    public function exportExcel()
    {
        $historyModel = new HistoryModel();

        $data = $historyModel
            ->select('tblhistory.*, users.username, tblpegawai.nama as nama_pegawai, tblservices.ServiceName')
            ->join('users', 'users.id_user = tblhistory.id_user')
            ->join('tblpegawai', 'tblpegawai.id_pegawai = tblhistory.id_pegawai', 'left')
            ->join('tblservices', 'tblservices.id_service = tblhistory.id_service')
            ->orderBy('tblhistory.tanggal', 'DESC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Member');
        $sheet->setCellValue('D1', 'Layanan');
        $sheet->setCellValue('E1', 'Pegawai');


        $row = 2;
        $no = 1;
        foreach ($data as $d) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d['tanggal']);
            $sheet->setCellValue('C' . $row, $d['username']);
            $sheet->setCellValue('D' . $row, $d['ServiceName']);
            $sheet->setCellValue('E' . $row, $d['nama_pegawai'] ?? 'Belum assign');

            $row++;
        }

        // Unduh file
        $filename = 'laporan-history.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportPenjualan()
    {
        $penjualanModel = new \App\Models\PembelianModel(); // sesuaikan modelnya

        // Ambil data penjualan, sesuaikan dengan tabel dan kolom yang kamu punya
        $data = $penjualanModel
            ->select('pembelian.*, tblproduk.nama_produk, tblproduk.harga')
            ->join('tblproduk', 'tblproduk.id_produk = pembelian.id_produk')
            ->orderBy('pembelian.tanggal', 'DESC')
            ->findAll();


        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Produk');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Harga');
        $sheet->setCellValue('F1', 'Total');


        $row = 2;
        $no = 1;
        foreach ($data as $d) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d['tanggal']);
            $sheet->setCellValue('C' . $row, $d['nama_produk']);
            $sheet->setCellValue('D' . $row, $d['jumlah']);
            $sheet->setCellValue('E' . $row, $d['harga']);
            $sheet->setCellValue('F' . $row, $d['jumlah'] * $d['harga']);

            $row++;
        }

        $filename = 'laporan-penjualan-' . date('Ymd_His') . '.xlsx';

        // Headers untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function absensi()
    {
        $absenModel = new Absen();
        $data['absensi'] = $absenModel->getAllAbsensi();

        return view('admin/absen', $data);
    }

    public function change_absen($tipe, $id_user)
    {
        $this->absenModel->where('id_user', $id_user)->set('tipe', $tipe)->update();
        return redirect()->back();
    }
}
