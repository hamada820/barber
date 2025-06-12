<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TablesMigration extends Migration
{
    public function up()
    {
        // 1. Users
        $this->forge->addField([
            'id_user'    => ['type' => 'INT', 'auto_increment' => true],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'number'     => ['type' => 'BIGINT', 'null' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'password'   => ['type' => 'TEXT'],
            'role'       => ['type' => 'ENUM("Admin","Kasir","Member","Pegawai")'],
            'RegDate' => [
                'type' => 'DATETIME',
                'default' => date('Y-m-d H:i:s')
            ],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('users');

        // 2. tblpegawai
        $this->forge->addField([
            'id_pegawai' => ['type' => 'INT', 'auto_increment' => true],
            'id_user'    => ['type' => 'INT'],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 25],
            'alamat'     => ['type' => 'TEXT'],
            'telepon'    => ['type' => 'VARCHAR', 'constraint' => 13],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 200],
        ]);
        $this->forge->addKey('id_pegawai', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('tblpegawai');

        // 3. tblservices
        $this->forge->addField([
            'id_service'        => ['type' => 'INT', 'auto_increment' => true],
            'ServiceName'       => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'ServiceDescription' => ['type' => 'TEXT', 'null' => true],
            'Cost'              => ['type' => 'INT', 'null' => true],
            'Image'             => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'Bookable'          => ['type' => 'TINYINT', 'constraint' => 1],
            'CreationDate'      => ['type' => 'TIMESTAMP', 'default' => date('Y-m-d H:i:s'), 'null' => true],
        ]);
        $this->forge->addKey('id_service', true);
        $this->forge->createTable('tblservices');

        // 4. tblproduk
        $this->forge->addField([
            'id_produk'   => ['type' => 'INT', 'auto_increment' => true],
            'nama_produk' => ['type' => 'VARCHAR', 'constraint' => 50],
            'deskripsi'   => ['type' => 'TEXT'],
            'harga'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'stok'        => ['type' => 'INT'],
            'Image'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_produk', true);
        $this->forge->createTable('tblproduk');

        // 5. booking
        $this->forge->addField([
            'id_booking'  => ['type' => 'INT', 'auto_increment' => true],
            'id_user'     => ['type' => 'INT'],
            'id_service'  => ['type' => 'INT'],
            'id_pegawai'  => ['type' => 'INT', 'null' => true],
            'status'      => ['type' => 'VARCHAR', 'constraint' => 20],
            'tanggal'     => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id_booking', true);
        $this->forge->createTable('booking');

        // 6. absen
        $this->forge->addField([
            'id_absen' => ['type' => 'INT', 'auto_increment' => true],
            'id_user'  => ['type' => 'INT'],
            'jam'      => ['type' => 'DATETIME'],
            'tipe'     => ['type' => 'VARCHAR', 'constraint' => 10],
        ]);
        $this->forge->addKey('id_absen', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('absen');

        // 7. email_verifications
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'auto_increment' => true],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'token'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('email_verifications');

        // 8. tblinvoiceproduk
        $this->forge->addField([
            'id_tblinvoiceproduk' => ['type' => 'INT', 'auto_increment' => true],
            'total'               => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id_tblinvoiceproduk', true);
        $this->forge->createTable('tblinvoiceproduk');

        // 9. pembelian
        $this->forge->addField([
            'id_pembelian'     => ['type' => 'INT', 'auto_increment' => true],
            'id_user'          => ['type' => 'INT'],
            'id_produk'        => ['type' => 'INT'],
            'id_invoiceproduk' => ['type' => 'INT', 'null' => true],
            'jumlah'           => ['type' => 'INT'],
            'total'            => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'status'           => ['type' => 'ENUM("menunggu","disetujui","ditolak")', 'default' => 'menunggu'],
            'tanggal'          => ['type' => 'TIMESTAMP'],
        ]);
        $this->forge->addKey('id_pembelian', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user');
        $this->forge->addForeignKey('id_produk', 'tblproduk', 'id_produk');
        $this->forge->addForeignKey('id_invoiceproduk', 'tblinvoiceproduk', 'id_tblinvoiceproduk');
        $this->forge->createTable('pembelian');

        // 10. tblinvoice
        $this->forge->addField([
            'id_invoice'  => ['type' => 'INT', 'auto_increment' => true],
            'id_user'     => ['type' => 'INT', 'null' => true],
            'id_service'  => ['type' => 'INT', 'null' => true],
            'id_pegawai'  => ['type' => 'INT'],
            'BillingId'   => ['type' => 'BIGINT', 'null' => true],
            'PostingDate' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => date('Y-m-d H:i:s')],
            'AmountPaid'  => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id_invoice', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('id_service', 'tblservices', 'id_service', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('id_pegawai', 'tblpegawai', 'id_pegawai', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('tblinvoice');

        // 11. tblhistory
        $this->forge->addField([
            'Id_history' => ['type' => 'INT', 'auto_increment' => true],
            'id_pegawai' => ['type' => 'INT'],
            'id_invoice' => ['type' => 'INT'],
            'id_user'    => ['type' => 'INT'],
            'id_service' => ['type' => 'INT'],
            'deskripsi'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'hasil'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tanggal'    => ['type' => 'TIMESTAMP'],
        ]);
        $this->forge->addKey('Id_history', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user');
        $this->forge->addForeignKey('id_service', 'tblservices', 'id_service');
        $this->forge->addForeignKey('id_invoice', 'tblinvoice', 'id_invoice');
        $this->forge->addForeignKey('id_pegawai', 'tblpegawai', 'id_pegawai');
        $this->forge->createTable('tblhistory');

        // 12. tblpage
        $this->forge->addField([
            'ID'              => ['type' => 'INT', 'auto_increment' => true],
            'PageType'        => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'PageTitle'       => ['type' => 'TEXT', 'null' => true],
            'PageDescription' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('ID', true);
        $this->forge->createTable('tblpage');

        $this->db->table('tblhistory')->truncate();
        $this->db->table('tblinvoice')->truncate();
        $this->db->table('pembelian')->truncate();
        $this->db->table('tblinvoiceproduk')->truncate();
        $this->db->table('email_verifications')->truncate();
        $this->db->table('absen')->truncate();
        $this->db->table('booking')->truncate();
        $this->db->table('tblproduk')->truncate();
        $this->db->table('tblservices')->truncate();
        $this->db->table('tblpegawai')->truncate();
        $this->db->table('tblpage')->truncate();
        $this->db->table('users')->truncate();
    }

    public function down()
    {
        $this->forge->dropTable('tblhistory', true);
        $this->forge->dropTable('tblinvoice', true);
        $this->forge->dropTable('pembelian', true);
        $this->forge->dropTable('tblinvoiceproduk', true);
        $this->forge->dropTable('email_verifications', true);
        $this->forge->dropTable('absen', true);
        $this->forge->dropTable('booking', true);
        $this->forge->dropTable('tblproduk', true);
        $this->forge->dropTable('tblservices', true);
        $this->forge->dropTable('tblpegawai', true);
        $this->forge->dropTable('tblpage', true);
        $this->forge->dropTable('users', true);
    }
}
