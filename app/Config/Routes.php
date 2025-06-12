<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/kritik-saran/kirim', 'Home::kirim');


// AUTH ROUTES
// LOGIN
$routes->get('login', 'Auth::login');           // Tampilkan form login
$routes->post('login', 'Auth::dologin');        // Proses login
// LOGOUT
$routes->get('logout', 'Auth::logout');         // Logout
// REGISTER
$routes->get('register', 'Auth::register');           // Tampilkan form register
$routes->post('register', 'Auth::registerProcess');   // Proses register
// EMAIL VERIFICATION
$routes->get('verify', 'Auth::verify');         // Verifikasi email
// Verifikasi email

// untuk proses autentikasi



//  route untuk halaman kasir
$routes->group('kasir', ['filter' => 'role:kasir'], function ($routes) {
    $routes->get('', 'Kasir::index');                         // /kasir
    $routes->get('booking', 'Kasir::booking');                // /kasir/riwayat
    $routes->post('booking-assign/(:num)', 'Kasir::bookingAssign/$1');                // /kasir/riwayat
    $routes->post('booking-assign/(:num)/(:any)', 'Kasir::bookingAssign/$1/$2');                // /kasir/riwayat
    $routes->get('riwayat', 'Kasir::riwayat');                // /kasir/riwayat
    $routes->get('riwayat/detail/(:num)', 'Kasir::detail/$1'); // /kasir/riwayat/detail/xx
    $routes->get('deleteRiwayat/(:num)', 'Kasir::delete/$1');
    $routes->get('editRiwayat/(:num)', 'Kasir::editRiwayat/$1');
    $routes->post('updateRiwayat/(:num)', 'Kasir::updateRiwayat/$1');
    $routes->get('pelanggan', 'Kasir::pelanggan');            // /kasir/pelanggan
    $routes->get('nonpelanggan', 'Kasir::nonpelanggan');            // /kasir/pelanggan
    $routes->post('nonpelanggan/store', 'Kasir::storeNonMember');
    $routes->put('nonpelanggan/update/(:num)', 'Kasir::updateNonMember/$1');
    $routes->delete('nonpelanggan/delete/(:num)', 'Kasir::deleteNonMember/$1');
    $routes->get('assign/(:num)', 'Kasir::assign/$1');        // /kasir/assign/xx
    $routes->post('assign/(:num)', 'Kasir::assignPost/$1');
    $routes->post('assign_promo/(:num)/(:any)', 'Kasir::assignPost/$1/$2');

    // /kasir/assign/xx POST
    // /kasir/absen/keluar
    $routes->get('kelola_pembelian', 'Kasir::kelolaPembelian');
    $routes->get('setujui-pembelian/(:num)', 'Kasir::setujuiPembelian/$1');
    $routes->get('tolak-pembelian/(:num)', 'Kasir::tolakPembelian/$1');
    $routes->post('create-invoice', 'Kasir::createInvoice');

    // Invoice

    $routes->get('invoices', 'Kasir::invoiceList');           // /kasir/invoices
    $routes->get('view_invoices/(:num)', 'Kasir::view/$1');    // /kasir/invoice/view/xx
    $routes->post('deleteinvoice/(:num)', 'Kasir::deleteInvoice/$1');
    $routes->get('invoice-produk', 'Kasir::viewInvoiceProduk');
    $routes->get('invoiceprodukdetail/(:num)', 'Kasir::detailInvoiceProduk/$1');
    $routes->post('deleteinvoiceproduk/(:num)', 'Kasir::deleteInvoiceProduk/$1');

    // /kasir/invoice/delete/xx
});




// Route halaman admin dengan filter role:admin
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'Admin::index');
    // Layanan (Services)
    $routes->get('addservice', 'Admin::addService');
    $routes->post('storeService', 'Admin::storeService');
    $routes->get('services', 'Admin::services');
    $routes->get('editservice/(:num)', 'Admin::editService/$1');
    $routes->post('updateservice/(:num)', 'Admin::updateService/$1');
    $routes->post('deleteservice/(:num)', 'Admin::deleteService/$1');
    // Member
    $routes->get('memberList', 'Admin::memberList');
    $routes->post('deleteuser/(:num)', 'Admin::deleteUser/$1');
    // Invoice
    $routes->get('invoices', 'Admin::invoiceList');
    $routes->get('view_invoices/(:num)', 'Admin::view/$1');        // ganti dari view_invoices
    $routes->post('invoices/delete/(:num)', 'Admin::deleteInvoice/$1');
    // Produk
    $routes->get('products', 'Admin::products');
    $routes->get('addproduct', 'Admin::addProduct');
    $routes->post('storeProduct', 'Admin::storeProduct');
    $routes->get('editproduct/(:num)', 'Admin::editProduct/$1');
    $routes->post('updateproduct/(:num)', 'Admin::updateProduct/$1');
    $routes->post('deleteproduct/(:num)', 'Admin::deleteProduct/$1');
    // Pegawai
    $routes->get('pegawai', 'Admin::pegawai');
    $routes->get('tambahPegawai', 'Admin::tambahPegawai');
    $routes->post('simpanPegawai', 'Admin::simpanPegawai');
    $routes->get('editPegawai/(:num)', 'Admin::editPegawai/$1');
    $routes->post('updatePegawai/(:num)', 'Admin::updatePegawai/$1');
    $routes->get('hapusPegawai/(:num)', 'Admin::hapusPegawai/$1');
    // Page (About dan Lokasi)
    $routes->get('editabout', 'Admin::editAbout');
    $routes->post('updateAbout', 'Admin::updateAbout');
    $routes->get('editlocation', 'Admin::editLocation');
    $routes->post('updateLocation', 'Admin::updateLocation');
    // Pembelian Produk oleh Member
    $routes->get('kelola_pembelian', 'Admin::kelolaPembelian'); // untuk melihat semua pembelian
    $routes->get('setujui-pembelian/(:num)', 'Admin::setujuiPembelian/$1'); // setujui pembelian
    $routes->get('tolak-pembelian/(:num)', 'Admin::tolakPembelian/$1');
    $routes->get('invoice-produk', 'Admin::viewInvoice');
    $routes->get('invoiceprodukdetail/(:num)', 'Admin::detailInvoice/$1'); // tolak pembelian
    $routes->post('create-invoice', 'Admin::createInvoice');

    $routes->get('laporan', 'admin::laporan');
    $routes->get('laporan/export-excel', 'admin::exportExcel');
    $routes->get('laporan/export-penjualan', 'Admin::exportPenjualan');

    $routes->get('absen', 'Admin::absensi');
});


$routes->group('member', ['filter' => 'rolefilter'], function ($routes) {
    $routes->get('dashboard', 'Member::dashboard');
    $routes->get('dashboard/(:num)', 'Member::invoiceHistory/$1');
    $routes->post('beli-produk', 'Member::beliProduk');
    $routes->post('beli-layanan', 'Member::beliLayanan');
});

$routes->group('pegawai', ['filter' => 'role:pegawai'], function ($routes) {
    $routes->get('/', 'Pegawai::index');
    $routes->get('riwayat', 'Pegawai::riwayat');            // /kasir/riwayat
    $routes->get('riwayat/detail/(:num)', 'Pegawai::detail/$1'); // /kasir/riwayat/detail/xx
    $routes->get('editRiwayat/(:num)', 'Pegawai::editRiwayat/$1');
    $routes->post('updateRiwayat/(:num)', 'Pegawai::updateRiwayat/$1');
});
// Absen
$routes->get('absen', 'Kasir::absen');                    // /kasir/absen
$routes->post('absen/hadir', 'Kasir::absenHadir');        // /kasir/absen/hadir
$routes->post('absen/hadir/(:any)', 'Kasir::absenHadir/$1');        // /kasir/absen/hadir
$routes->post('absen/keluar', 'Kasir::absenKeluar');     // /kasir/riwayat
$routes->get('change_absen/(:any)/(:num)', 'Admin::change_absen/$1/$2');     // /kasir/riwayat

$routes->post('update-profile', 'Auth::profileUpdate');     // /kasir/riwayat