<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'tblinvoice';
    protected $primaryKey       = 'id_invoice';

    protected $allowedFields    = [
        'id_user',
        'id_pegawai',
        'id_service',
        'BillingId',
        'PostingDate',
        'AmountPaid'
    ];

    protected $useTimestamps = false; // Tidak pakai created_at/updated_at

    
    public function getPegawaiByInvoice($id_invoice)
{
    return $this->db->table('tblhistory h')
        ->select('p.pegawai, p.alamat, p.telepon')
        ->join('tblpegawai p', 'p.id_pegawai = h.id_pegawai')
        ->where('h.id_invoice', $id_invoice)
        ->get()
        ->getResultArray();
}

public function getCustomerByInvoice($id_invoice)
{
    return $this->db->table('tblinvoice i')
        ->select('u.username, u.email, u.number, u.RegDate, i.PostingDate as invoicedate')
        ->join('users u', 'u.id_user = i.id_user')
        ->where('i.BillingId', $id_invoice)
        ->get()
        ->getRowArray();
}

public function getInvoiceDetails($id_invoice)
    {
        return $this->db->table('tblinvoice')
            ->select('
                tblinvoice.BillingId,
                DATE(tblinvoice.PostingDate) as invoicedate,
                users.username,
                users.email,
                users.number,
                users.RegDate,
                tblservices.ServiceName,
                tblservices.Cost,
                tblinvoice.AmountPaid,
                
            ')
            ->join('users', 'users.id_user = tblinvoice.id_user')
            ->join('tblservices', 'tblservices.id_service = tblinvoice.id_service')
            ->where('tblinvoice.BillingId', $id_invoice)
            ->get()
            ->getResultArray();
    }

}
