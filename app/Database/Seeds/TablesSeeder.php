<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TablesSeeder extends Seeder
{
    public function run()
    {
        // users
        $this->db->table('users')->insertBatch([
            [
                'id_user' => 70,
                'username' => 'hamada',
                'number' => 824182818,
                'email' => 'm.fadil.hamada@mhs.politala.ac.id',
                'password' => '$2y$10$3AAQkoH6peACcg.PpxqR9uItFnE21q9xRzyA1a9bwMxwThlTeWGje',
                'role' => 'Member',
                'RegDate' => '2025-05-22 05:04:38',
                'is_active' => 1
            ],
            [
                'id_user' => 74,
                'username' => 'kharisma',
                'number' => 81385757522,
                'email' => 'kharismabarbershp@gmail.com',
                'password' => '$2y$10$dLg/37xDHq12LpsuaPsROOkCTYoteFoXwjCvwPK6zdsHlQBL.xSR6',
                'role' => 'Admin',
                'RegDate' => '2025-05-22 18:34:32',
                'is_active' => 1
            ],
            // Tambahkan user lainnya sesuai file SQL jika diperlukan
        ]);

        // tblpegawai
        $this->db->table('tblpegawai')->insertBatch([
            [
                'id_pegawai' => 2,
                'id_user' => 75,
                'nama' => 'Fadil ganteng',
                'alamat' => 'karang jawa',
                'telepon' => '089637190439',
                'image' => '1747940403_9926b2e295babda08554.jpeg'
            ],
            [
                'id_pegawai' => 3,
                'id_user' => 76,
                'nama' => 'utuh',
                'alamat' => 'panyipatan',
                'telepon' => '097908980909',
                'image' => '1747941620_655c320c4d39f5661625.jpeg'
            ]
        ]);

        // tblservices
        $this->db->table('tblservices')->insertBatch([
            [
                'id_service' => 26,
                'ServiceName' => 'Perming',
                'ServiceDescription' => 'masbrooasaa',
                'Cost' => 250000,
                'Image' => '1747934761_b9103df6f7781f6d4029.png',
                'Bookable' => 1,
                'CreationDate' => '2023-05-13 01:23:03'
            ],
            [
                'id_service' => 27,
                'ServiceName' => 'Kharis-man',
                'ServiceDescription' => 'hahahihihehee',
                'Cost' => 50000,
                'Image' => '9eafb1f147ce942a3996142217f666d81683941287.jpg',
                'Bookable' => 0,
                'CreationDate' => '2023-05-13 01:28:07'
            ]
        ]);

        // tblproduk
        $this->db->table('tblproduk')->insertBatch([
            [
                'id_produk' => 4,
                'nama_produk' => 'hair paste huhu',
                'deskripsi' => 'lorem ipsum dolor sit amet nguna ngana',
                'harga' => 90000.00,
                'stok' => 7,
                'Image' => '1747420193_7491a8dff3010f57ebb9.jpeg',
                'created_at' => '2025-05-16 18:14:49',
                'updated_at' => '2025-05-27 11:46:25'
            ],
            [
                'id_produk' => 5,
                'nama_produk' => 'hairpro water based',
                'deskripsi' => 'jika aku bukan jalanamu asnudannsaindsjaincas',
                'harga' => 90000.00,
                'stok' => 1,
                'Image' => '1747421809_65264f15c34d71ba02c6.png',
                'created_at' => '2025-05-16 18:56:49',
                'updated_at' => '2025-05-26 23:59:24'
            ]
        ]);

        // tblpage
        $this->db->table('tblpage')->insertBatch([
            [
                'ID' => 1,
                'PageType' => 'aboutus',
                'PageTitle' => 'About Us',
                'PageDescription' => 'kami adalah Barbershop yang telah berdiri sejak tahun 2004...'
            ],
            [
                'ID' => 3,
                'PageType' => 'location',
                'PageTitle' => 'Lokasi Barber',
                'PageDescription' => '<iframe src="https://www.google.com/maps/embed?..."></iframe>'
            ]
        ]);

        // tblinvoiceproduk
        $this->db->table('tblinvoiceproduk')->insert([
            'id_tblinvoiceproduk' => 1,
            'total' => 360000
        ]);

        // email_verifications
        $this->db->table('email_verifications')->insert([
            'id' => 18,
            'email' => 'fadliyudha007@gmail.com',
            'token' => '394a5f7ca0ec204d6efa2388f42eb324',
            'created_at' => '0000-00-00 00:00:00'
        ]);

        // booking
        $this->db->table('booking')->insert([
            'id_booking' => 1,
            'id_user' => 70,
            'id_service' => 26,
            'id_pegawai' => 2,
            'status' => 'Assigned',
            'tanggal' => '2025-05-29 02:52:48'
        ]);

        // absen
        $this->db->table('absen')->insert([
            'id_absen' => 3,
            'id_user' => 75,
            'jam' => '2025-05-31 03:37:33',
            'tipe' => 'Hadir'
        ]);

        // tblinvoice
        $this->db->table('tblinvoice')->insert([
            'id_invoice' => 76,
            'id_user' => 70,
            'id_service' => 29,
            'id_pegawai' => 3,
            'BillingId' => 2487362200,
            'PostingDate' => '2025-05-26 18:37:27',
            'AmountPaid' => 15000
        ]);

        // tblhistory
        $this->db->table('tblhistory')->insert([
            'Id_history' => 19,
            'id_pegawai' => 3,
            'id_invoice' => 76,
            'id_user' => 70,
            'id_service' => 29,
            'deskripsi' => null,
            'hasil' => null,
            'tanggal' => '2025-05-26 18:37:27'
        ]);
    }
}
