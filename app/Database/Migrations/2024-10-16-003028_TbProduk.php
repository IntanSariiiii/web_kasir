<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbProduk extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
            "produk_id"=>[
                'type'=> 'int',
                'constraint' => 11,
                'auto_increment' => true,
                'null' => false,
            ],
            "nama_produk" => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            "harga" =>[
                'type' => 'decimal',
                'constraint' => '10,2',
            ],
            "stok" => [
                'type' => 'int',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('produk_id', true);

        // Membuat tabel tb_produk
        $this->forge->createTable('tb_produk');
    }

    public function down()
    {
        // Menghapus tabel tb_produk saat rollback
        $this->forge->dropTable('tb_produk');
    }
}