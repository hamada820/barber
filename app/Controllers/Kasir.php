<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use Config\Services;
use App\Models\Absen;
use App\Models\ServiceModel;
use App\Models\UserModel;
use App\Models\HistoryModel;
use App\Models\PegawaiModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceProduk;
use App\Models\Booking;
use CodeIgniter\Controller;

class Kasir extends BaseController
{
    protected $userModel;
    protected $layananModel;
    protected $pegawaiModel;
    protected $historyModel;
    protected $bookingModel;
    protected $absenModel;
    protected $invoiceModel;
    protected $invoiceProdukModel;

    public function __construct()
    {
        $this->absenModel     = new Absen();
        $this->layananModel  = new ServiceModel(); // nama modelmu untuk layanan
        $this->bookingModel  = new Booking(); // nama modelmu untuk layanan
        $this->pegawaiModel  = new PegawaiModel(); // pastikan model ini sudah ada
        $this->historyModel  = new HistoryModel(); // pastikan model ini sudah ada
        $this->userModel  = new UserModel(); // pastikan model ini sudah ada
        $this->invoiceModel = new InvoiceModel();
        $this->invoiceProdukModel     = new InvoiceProduk();
    }

    public function index()
    {
        $data = [
            'totalServices' => $this->layananModel->countAll(),
            'totalUsers'    => $this->userModel->countAll(),
        ];

        return view('kasir/index', $data);
    }

    public function riwayat()
    {
        $data['users'] = $this->userModel->where('role', 'member')->findAll();
        return view('kasir/riwayat', $data);
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
        $builder->orderBy('tanggal', 'DESC');
        $data['riwayat'] = $builder->get()->getResultArray();
        return view('kasir/riwayat_detail', $data);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('tblhistory')->delete(['id_history' => $id]);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function pelanggan()
    {
        $data['users'] = $this->userModel->where('role', 'member')->findAll();
        return view('kasir/pelanggan', $data);
    }


    public function assign($id_user)
    {
        $user    = $this->userModel->find($id_user);
        $layanan = $this->layananModel->findAll();
        $pegawai = $this->pegawaiModel->findAll();

        return view('kasir/assign_layanan', [
            'user'    => $user,
            'layanan' => $layanan,
            'pegawai' => $pegawai
        ]);
    }

    public function assignPost($id_user, $promo = NULL)
    {
        $db = \Config\Database::connect();
        $selectedServices = $this->request->getPost('sids');
        $pegawaiId = $this->request->getPost('id_pegawai');
        $db->query('SET FOREIGN_KEY_CHECKS=0');
        if ($selectedServices && $pegawaiId) {

            $invoiceModel = new \App\Models\InvoiceModel();
            $historyModel = new \App\Models\HistoryModel();
            $serviceModel = new \App\Models\ServiceModel();
            $userModel = new \App\Models\UserModel(); // tambahkan model user
            $user = $userModel->find($id_user);
            // Model untuk layanan

            foreach ($selectedServices as $serviceId) {
                // 1. Ambil harga layanan dari tblservices
                $service = $serviceModel->find($serviceId);
                $servicePrice = $service['Cost']; // Asumsi nama kolom harga adalah 'Cost'

                // 2. Generate BillingId unik (opsional tapi disarankan)
                do {
                    $billingId = random_int(1000000000, 9999999999);
                } while ($invoiceModel->where('BillingId', $billingId)->first());

                // 2. Buat invoice terlebih dahulu  
                if ($promo != NULL) {
                    $invoiceData = [
                        'id_user'     => $id_user,
                        'id_service'  => $serviceId,
                        'id_pegawai' => $pegawaiId,
                        'PostingDate' => date('Y-m-d H:i:s'),
                        'BillingId'   => $billingId,
                        'AmountPaid'  => $this->request->getPost('harga_promo'), // Masukkan harga layanan ke AmountPaid
                    ];
                } else {
                    $invoiceData = [
                        'id_user'     => $id_user,
                        'id_service'  => $serviceId,
                        'id_pegawai'  => $pegawaiId,
                        'PostingDate' => date('Y-m-d H:i:s'),
                        'BillingId'   => $billingId,
                        'AmountPaid'  => $servicePrice // Masukkan harga layanan ke AmountPaid
                    ];
                }
                $invoiceModel->insert($invoiceData);
                $id_invoice = $invoiceModel->insertID();

                if (!$id_invoice || !$invoiceModel->find($id_invoice)) {
                    return redirect()->back()->with('error', 'Gagal membuat invoice.');
                }

                $invoiceLengkap = $invoiceModel
                    ->join('tblpegawai', 'tblpegawai.id_pegawai = tblinvoice.id_pegawai')
                    ->join('tblservices', 'tblservices.id_service = tblinvoice.id_service')
                    ->where('tblinvoice.id_invoice', $id_invoice)
                    ->first();

                // 3. Pastikan ID invoice valid, baru insert ke tblhistory
                if ($id_invoice) {
                    $historyModel->insert([
                        'id_user'    => $id_user,
                        'id_pegawai' => $pegawaiId,
                        'id_service' => $serviceId,
                        'id_invoice' => $id_invoice, // Masukkan ID invoice yang baru
                        'tanggal'    => date('Y-m-d H:i:s'),
                        'deskripsi'  => 'Assign oleh kasir', // Deskripsi untuk assignment
                        'hasil'      => null,  // Hasil assignment (bisa ditambahkan jika perlu)
                        // Gambar hasil (bisa ditambahkan jika perlu)
                    ]);
                }
                $this->kirimInvoiceEmail($user['email'], $user['username'], $invoiceLengkap);
            }
            $db->query('SET FOREIGN_KEY_CHECKS=1');

            return redirect()->to('/kasir/riwayat/detail/' . $id_user)
                ->with('success', 'Layanan berhasil di-assign dan invoice dibuat.');
        }
        $db->query('SET FOREIGN_KEY_CHECKS=1');

        return redirect()->back()->with('error', 'Silakan pilih layanan dan pegawai.');
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
    public function absen()
    {
        return view('kasir/absen');
    }
    public function absenHadir($tipe = NULL)
    {
        $absen = $this->absenModel
            ->where([
                'id_user' => session('id_user'),
            ])
            ->like('jam', Time::now('Asia/Makassar')->toDateString()) // Cek apakah kolom 'jam' mengandung tanggal hari ini
            ->first();
        if ($absen != NULL) {
            return redirect()->to(base_url('absen'))->with('error', 'Anda sudah mengisi form absen');
        }
        $now = Time::now('Asia/Makassar');
        if ($tipe != NULL && session('role') == 'Pegawai') {
            $this->absenModel->save([
                'id_user' => session('id_user'),
                'tipe' => 'Libur',
                'jam' => Time::now('Asia/Makassar')->toDateTimeString()
            ]);
            return redirect()->to(base_url('absen'))->with('success', 'Berhasil libur');
        }
        if ($now->format('H') >= '3' && $tipe == NULL) {
            $this->absenModel->save([
                'id_user' => session('id_user'),
                'tipe' => 'Hadir',
                'jam' => Time::now('Asia/Makassar')->toDateTimeString()
            ]);
            return redirect()->to(base_url('absen'))->with('success', 'Berhasil hadir');
        } else {
            return redirect()->to(base_url('absen'))->with('error', 'Belum jam hadir');
        }
        return redirect()->to(base_url('absen'))->with('error', 'Gagal hadir');
    }
    public function absenKeluar()
    {
        $keluar = $this->absenModel
            ->where([
                'id_user' => session('id_user'),
                'tipe' => 'Keluar'
            ])
            ->like('jam', Time::now('Asia/Makassar')->toDateString()) // Cek apakah kolom 'jam' mengandung tanggal hari ini
            ->first();
        $absen = $this->absenModel
            ->where([
                'id_user' => session('id_user'),
                'tipe' => 'Hadir'
            ])
            ->like('jam', Time::now('Asia/Makassar')->toDateString()) // Cek apakah kolom 'jam' mengandung tanggal hari ini
            ->first();
        if ($keluar != NULL) {
            return redirect()->to(base_url('absen'))->with('error', 'Anda sudah keluar');
        }
        if ($absen == NULL) {
            return redirect()->to(base_url('absen'))->with('error', 'Anda belum hadir');
        }
        $now = Time::now('Asia/Makassar');
        if ($now->format('H') >= '3') {
            $this->absenModel->save([
                'id_user' => session('id_user'),
                'tipe' => 'Keluar',
                'jam' => Time::now('Asia/Makassar')->toDateTimeString()
            ]);
            return redirect()->to(base_url('absen'))->with('success', 'Berhasil keluar');
        } else {
            return redirect()->to(base_url('absen'))->with('error', 'Belum jam keluar');
        }
        return redirect()->to(base_url('absen'))->with('error', 'Gagal keluar');
    }

    public function invoiceList()
    {
        $invoices = $this->invoiceModel
            ->select('tblinvoice.*, users.username, users.email, tblservices.ServiceName')
            ->join('users', 'users.id_user = tblinvoice.id_user', 'left')
            ->join('tblservices', 'tblservices.id_service = tblinvoice.id_service', 'left')
            ->findAll();

        return view('kasir/invoices', [ // Gunakan view yang sama
            'invoices' => $invoices
        ]);
    }

    // Hapus invoice
    public function deleteInvoice($id)
    {
        $this->invoiceModel->delete($id);
        return redirect()->to('/kasir/invoices')->with('info', 'Invoice berhasil dihapus.');
    }

    // Detail invoice
    public function view($id_invoice = null)
    {
        if ($id_invoice === null) {
            return redirect()->to('/kasir/invoices')->with('error', 'Invoice ID tidak ditemukan');
        }

        // Load model
        $invoiceModel = new InvoiceModel();
        $pegawaiModel = new PegawaiModel();

        // Ambil data invoice
        $invoiceData = $invoiceModel
            ->join('tblpegawai', 'tblpegawai.id_pegawai = tblinvoice.id_pegawai')
            ->join('tblservices', 'tblservices.id_service = tblinvoice.id_service')
            ->where('tblinvoice.id_invoice', $id_invoice)
            ->first();

        if (!$invoiceData) {
            return redirect()->to('/kasir/invoices')->with('error', 'Invoice tidak ditemukan');
        }

        $data = [
            'invoice' => $invoiceData
        ];

        return view('kasir/view_invoices', $data); // Gunakan view yang sama
    }

    public function kelolaPembelian()
    {
        $model = new \App\Models\PembelianModel();
        $data['pembelian'] = $model->getPembelianDenganProdukDanUser();

        return view('kasir/kelola_pembelian', $data);
    }

    public function setujuiPembelian($id_pembelian)
    {
        $pembelianModel = new \App\Models\PembelianModel();
        $produkModel = new \App\Models\ProductModel();
        $invoiceModel = new \App\Models\InvoiceModel();
        $db = \Config\Database::connect();

        $pembelian = $pembelianModel->find($id_pembelian);
        if (!$pembelian) {
            return redirect()->back()->with('error', 'Data pembelian tidak ditemukan.');
        }

        $produk = $produkModel->find($pembelian['id_produk']);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($produk['stok'] < $pembelian['jumlah']) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $pembelianModel->update($id_pembelian, ['status' => 'disetujui']);
        $db->query('SET FOREIGN_KEY_CHECKS=0');
        $produkModel->update($produk['id_produk'], [
            'stok' => $produk['stok'] - $pembelian['jumlah']
        ]);

        $billingId = 'INV-' . strtoupper(uniqid());
        $invoiceModel->insert([
            'id_user'     => $pembelian['id_user'],
            'id_service'  => $pembelian['id_produk'],
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
        if (empty($id_pembelian)) {
            return redirect()->back()->with('pesan', 'Tidak ada pembelian yang dipilih.');
        }

        $pembelianModel = new \App\Models\PembelianModel();
        $invoiceProdukModel = new \App\Models\InvoiceProduk();
        $userModel = new \App\Models\UserModel();

        // Hitung total keseluruhan
        $grandTotal = 0;
        foreach ($id_pembelian as $key) {
            $pembelian = $pembelianModel->find($key);
            if ($pembelian) {
                $grandTotal += $pembelian['total'];
            }
        }

        // Buat invoice produk
        $invoiceProdukModel->insert([
            'total' => $grandTotal,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        $invoiceId = $invoiceProdukModel->getInsertID();

        if (!$invoiceId) {
            return redirect()->back()->with('pesan', 'Gagal membuat invoice.');
        }

        // Update pembelian dengan id_invoiceproduk
        foreach ($id_pembelian as $key) {
            $pembelianModel->update($key, [
                'id_invoiceproduk' => $invoiceId
            ]);
        }

        // Ambil semua pembelian yang baru diupdate (invoice yang sama) grup per user
        $pembelianList = $pembelianModel->whereIn('id_pembelian', $id_pembelian)->findAll();

        // Group pembelian per user
        $groupedByUser = [];
        foreach ($pembelianList as $item) {
            $groupedByUser[$item['id_user']][] = $item;
        }

        // Kirim email invoice per user
        foreach ($groupedByUser as $id_user => $items) {
            $user = $userModel->find($id_user);
            if (!$user || empty($user['email'])) {
                continue; // skip user tanpa email
            }

            // Siapkan data invoice untuk user
            $invoiceData = [
                'id_invoice' => $invoiceId,
                'tanggal' => date('d-m-Y'),
                'total' => 0,
                'items' => []
            ];
            $items = $pembelianModel
                ->join('tblproduk', 'tblproduk.id_produk = pembelian.id_produk')
                ->whereIn('pembelian.id_pembelian', $id_pembelian)
                ->findAll();
            $totalUser = 0;
            foreach ($items as $row) {
                $invoiceData['items'][] = $row;
                $totalUser += $row['total'];
            }
            // var_dump($invoiceData);
            // die;
            $invoiceData['total'] = $totalUser;

            // Kirim email
            $this->kirimInvoiceEmailProduk($user['email'], $user['username'], $invoiceData);
        }

        return redirect()->to(base_url('kasir/invoice-produk'))->with('pesan', 'Invoice berhasil dibuat dan email terkirim.');
    }


    public function viewInvoiceProduk()
    {
        $invoiceProdukModel = new \App\Models\InvoiceProduk();
        $data = [
            'data' => $invoiceProdukModel->findAll(),
        ];
        return view('kasir/invoice-produk', $data);
    }

    public function detailInvoiceProduk($id)
    {
        $pembelianModel = new \App\Models\PembelianModel();
        $data = [
            'id_invoiceproduk' => $id,
            'data' => $pembelianModel
                ->where('id_invoiceproduk', $id)
                ->join('users', 'users.id_user = pembelian.id_user')
                ->join('tblproduk', 'tblproduk.id_produk = pembelian.id_produk')
                ->findAll(),
        ];
        return view('kasir/invoiceprodukdetail', $data);
    }

       public function deleteInvoiceproduk($id)
    {
        $this->invoiceProdukModel->delete($id);
        return redirect()->to('/kasir/invoice-produk')->with('info', 'Invoice berhasil dihapus.');
    }

    public function booking()
    {
        $data = [
            'booking' => $this->bookingModel
                ->join('tblpegawai', 'booking.id_pegawai = tblpegawai.id_pegawai', 'left')
                ->join('tblservices', 'tblservices.id_service = booking.id_service')
                ->join('users', 'users.id_user = booking.id_user')
                ->findAll(),
            'pegawai' => $this->pegawaiModel->findAll(),
        ];
        return view('kasir/booking', $data);
    }


    public function bookingAssign($id_booking, $promo = NULL)
    {
        $data = $this->bookingModel
            ->join('tblservices', 'booking.id_service = tblservices.id_service')
            ->join('users', 'users.id_user = booking.id_user')
            ->select('booking.*, tblservices.Cost, tblservices.ServiceName, users.email, users.username')
            ->find($id_booking);
        if (!$data) {
            return redirect()->back()->with('error', 'Data booking tidak ditemukan.');
        }
        $idPegawai = $this->request->getPost('id_pegawai');
        $tanggal = $this->request->getPost('tanggal');
        if (!$tanggal || strtotime($tanggal) < time()) {
            return redirect()->back()->with('error', 'Tanggal booking tidak valid. Harus setelah waktu sekarang.');
        }
        // Update booking dengan id_pegawai
        $this->bookingModel->update($id_booking, [
            'id_pegawai' => $idPegawai,
            'tanggal' => $tanggal,
            'status' => 'Assigned',
        ]);

        // Insert ke tabel invoice
        if ($promo ==  NULL) {
            $invoiceData = [
                'id_user' => $data['id_user'],
                'id_service' => $data['id_service'],
                'id_pegawai' => $idPegawai,
                'BillingId' => random_int(1000000000, 9999999999),
                'PostingDate' => Time::now(),
                'AmountPaid' => $data['Cost'],
            ];
        } else {
            $invoiceData = [
                'id_user' => $data['id_user'],
                'id_service' => $data['id_service'],
                'id_pegawai' => $idPegawai,
                'BillingId' => random_int(1000000000, 9999999999),
                'PostingDate' => Time::now(),
                'AmountPaid' => $this->request->getPost('harga_promo'),
            ];
        }
        $this->invoiceModel->save($invoiceData);
        $idInvoice = $this->invoiceModel->getInsertID();

        // Simpan ke history
        $this->historyModel->save([
            'id_user' => $data['id_user'],
            'id_service' => $data['id_service'],
            'id_pegawai' => $idPegawai,
            'id_invoice' => $idInvoice,
            'tanggal' => Time::now(),
            'deskripsi' => 'Assign dari Booking',
        ]);

        // Kirim email notifikasi
        $emailService = Services::email();
        $emailService->setFrom('kharismabarbershp@gmail.com', 'Kharisma Barbershop');
        $emailService->setTo($data['email']);
        $emailService->setSubject('Layanan Anda Telah Dikonfirmasi');

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
            <h2>Halo, {$data['username']}!</h2>
            <p>Terima kasih telah booking di <strong>Kharisma Barbershop</strong>.</p>
            <p>Layanan <strong>{$data['ServiceName']}</strong> Anda telah berhasil <strong>di-assign</strong> ke barber pilihan kami.</p>
            <p>Silakan datang sesuai jadwal yang telah Anda pilih. Kami siap melayani Anda dengan sepenuh hati!</p>
            <p>Info tambahan:</p>
            <ul>
                <li>Tanggal Booking: <strong>{$data['tanggal']}</strong></li>
                <li>Harga: <strong>Rp " . number_format($data['Cost']) . "</strong></li>
            </ul>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami melalui email ini.</p>
            <div class='footer'>&copy; " . date('Y') . " Kharisma Barbershop. All rights reserved.</div>
        </div>
    </body>
    </html>
    ";

        $emailService->setMessage($message);
        $emailService->setMailType('html');

        if (!$emailService->send()) {
            log_message('error', 'Gagal mengirim email ke ' . $data['email'] . '. Debug: ' . print_r($emailService->printDebugger(['headers', 'subject']), true));
        } else {
            log_message('info', 'Notifikasi booking berhasil dikirim ke ' . $data['email']);
        }

        return redirect()->to('/kasir/pelanggan')->with('success', 'Assign layanan berhasil dilakukan dan email notifikasi telah dikirim.');
    }
    private function kirimInvoiceEmailProduk($email, $nama, $invoice)
    {
        $emailService = \Config\Services::email();
        $emailService->setFrom('kharismabarbershp@gmail.com', 'Kharisma Barbershop');
        $emailService->setTo($email);
        $emailService->setSubject('Invoice Transaksi Produk Anda - Kharisma Barbershop');

        // Load logo dan encode base64 untuk inline image di email/pdf
        $logoPath = FCPATH . 'assets/img/logokharisma.png';
        $logoBase64 = base64_encode(file_get_contents($logoPath));

        // Generate HTML invoice PDF
        $html = view('kasir/invoice_produk_pdf', [
            'username' => $nama,
            'invoice' => $invoice,
            'logoBase64' => $logoBase64
        ]);

        // Generate PDF dengan Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfOutput = $dompdf->output();
        $tempPath = WRITEPATH . 'uploads/invoice_produk_' . $invoice['id_invoice'] . '.pdf';
        file_put_contents($tempPath, $pdfOutput);

        // Body email
        $message = "
        <h3>Halo, {$nama}!</h3>
        <p>Terima kasih telah melakukan pembelian produk di <strong>Kharisma Barbershop</strong>.</p>
        <p>Invoice transaksi produk Anda terlampir dalam bentuk PDF.</p>
        <p>Salam hangat,<br>Kharisma Barbershop</p>
    ";
        $emailService->setMessage($message);
        $emailService->setMailType('html');
        $emailService->attach($tempPath);

        if (!$emailService->send()) {
            log_message('error', 'Gagal mengirim invoice produk ke ' . $email);
        } else {
            log_message('info', 'Invoice produk berhasil dikirim ke ' . $email);
        }

        unlink($tempPath);
    }
    private function kirimInvoiceEmail($email, $nama, $invoice)
    {
        $emailService = \Config\Services::email();
        $emailService->setFrom('kharismabarbershp@gmail.com', 'Kharisma Barbershop');
        $emailService->setTo($email);
        $emailService->setSubject('Invoice Transaksi Anda - Kharisma Barbershop');

        $logoPath = FCPATH . 'assets/img/logokharisma.png';
        $logoBase64 = base64_encode(file_get_contents($logoPath));
        // Ambil nama layanan dari database (jika belum disiapkan sebelumnya)
        $serviceModel = new \App\Models\ServiceModel();
        $layanan = $serviceModel->find($invoice['id_service']);
        $namaLayanan = $invoice['ServiceName'] ?? 'Layanan Tidak Diketahui';
        // ✅ Gunakan view invoice untuk generate HTML PDF
        $html = view('kasir/invoice_produk_pdf', [
            'username' => $nama,
            'invoice' => $invoice,
            'layanan' => $namaLayanan,
            'logoBase64' => $logoBase64
        ]);

        // ✅ Konversi ke PDF
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // ✅ Simpan PDF sementara
        $pdfOutput = $dompdf->output();
        $tempPath = WRITEPATH . 'uploads/invoice_' . $invoice['BillingId'] . '.pdf';
        file_put_contents($tempPath, $pdfOutput);

        // ✅ Isi body email
        $message = "
        <h3>Halo, {$nama}!</h3>
        <p>Terima kasih telah melakukan transaksi di <strong>Kharisma Barbershop</strong>.</p>
        <p>Invoice transaksi Anda terlampir dalam bentuk PDF.</p>
        <p>Salam hangat,<br>Kharisma Barbershop</p>
    ";
        $emailService->setMessage($message);
        $emailService->setMailType('html');

        // ✅ Lampirkan PDF
        $emailService->attach($tempPath);

        // ✅ Kirim
        if (!$emailService->send()) {
            log_message('error', 'Gagal mengirim invoice ke ' . $email);
        } else {
            log_message('info', 'Invoice berhasil dikirim ke ' . $email);
        }

        // ✅ Hapus file PDF sementara
        unlink($tempPath);
    }
}
