<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "pelanggan_id"=>[
                'type'=> 'int',
                'constraint' => 11,
                'auto_increment' => true,
                'null' => false,
            ],
            "nama_pelanggan" => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            "alamat" =>[
                'type' => 'varchar',
                'constraint' => '255',
            ],
            "nomor_tlp" => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('pelanggan_id', true);

        // Membuat tabel tb_pelanggan
        $this->forge->createTable('tb_pelanggan');
    }

    public function down()
    {
        // Menghapus tabel tb_pelanggan saat rollback
        $this->forge->dropTable('tb_pelanggan');
    }
}