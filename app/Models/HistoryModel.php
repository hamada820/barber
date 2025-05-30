<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $table = 'tblhistory';
    protected $primaryKey = 'id_history';
    protected $allowedFields = ['id_user', 'id_pegawai', 'id_service', 'id_invoice', 'tanggal', 'deskripsi', 'hasil', 'gambar'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;

    // Method untuk mengambil data history lengkap dengan nama pegawai
    public function getHistoryWithPegawai()
    {
        return $this->db->table($this->table)
            ->select('tblhistory.*, pegawai.nama as nama_pegawai')
            ->join('pegawai', 'pegawai.id_pegawai = tblhistory.id_pegawai')
            ->get()
            ->getResultArray();
    }

    // Jika kamu mau ambil hanya satu riwayat tertentu
    public function getUserHistoryWithPegawai($userId)
{
    return $this->db->table($this->table)
        ->select('tblhistory.id_history, tblhistory.id_invoice, tblhistory.tanggal, tblhistory.deskripsi, tblhistory.hasil, tblhistory.id_pegawai, tblpegawai.nama as nama_pegawai')
        ->join('tblpegawai', 'tblpegawai.id_pegawai = tblhistory.id_pegawai')
        ->where('tblhistory.id_user', $userId)
        ->orderBy('tblhistory.tanggal', 'DESC')
        ->get()
        ->getResultArray();
}
public function getLaporanPerPegawai()
    {
        return $this->select('tblpegawai.nama as pegawai, COUNT(tblhistory.id_history) as total_history, COUNT(tblinvoice.id_invoice) as total_invoice')
            ->join('tblpegawai', 'tblpegawai.id_pegawai = tblhistory.id_pegawai')
            ->join('tblinvoice', 'tblinvoice.id_invoice = tblhistory.id_invoice', 'left')
            ->groupBy('tblpegawai.id_pegawai')
            ->findAll();
    }

}
