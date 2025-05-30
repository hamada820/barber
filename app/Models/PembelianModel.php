<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $allowedFields = ['id_user', 'id_produk', 'jumlah', 'total', 'status', 'tanggal', 'id_invoiceproduk'];


public function getPembelianDenganProdukDanUser()
{
    return $this->select('pembelian.*, users.username, tblproduk.nama_produk, tblproduk.harga, tblproduk.Image')
                ->join('users', 'users.id_user = pembelian.id_user')
                ->join('tblproduk', 'tblproduk.id_produk = pembelian.id_produk')
                ->orderBy('pembelian.id_pembelian', 'DESC')
                ->findAll();
}

}
