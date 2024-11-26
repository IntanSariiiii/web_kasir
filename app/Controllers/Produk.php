<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkmodel;

    public function __construct()
    {
        $this->produkmodel = new ProdukModel();
    }
    public function index()
    {
        return view('data_produk/v_produk');
    }

    public function simpan_produk()
    {
        //validasi input dari AJAX
        // $validation = \Config\Services::validation();

        // $validation->setRules([
        //     'nama_produk'   => 'required',
        //     'harga'         => 'required|decimal',
        //     'stok'          => 'required|integer',
        // ]);

        // if(!$validation->withRequest($this->request)->run()){
        //     return $this->response->setJSON([
        //         'status'    => 'error',
        //         'errors'    => $validation->getErrors(),
        //     ]);
        // }
        
        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
            'stok'  => $this->request->getVar('stok'),
        ];

        $this->produkmodel->save($data);

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Data produk berhasil disimpan',
        ]);
    
    }

    public function tampil_produk()
    {
        $produk = $this->produkmodel->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'produk' => $produk
        ]);
    }

    public function hapus_data($id){
        $result = $this->produkmodel->delete($id);
        if ($result){
            echo json_encode(['status'=> 'success', 'message'=> 'Produk dihapus']);
        } else{
            echo json_encode(['status'=> 'error', 'message'=> 'gkbs']);
        }
    }
    public function edit_produk($id)
    {
        $produk = $this->produkmodel->find($id);
        if ($produk) {
            return $this->response->setJSON(['status' => 'success', 'produk' => $produk]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan.']);
        }
    }

    public function update_produk()
    {
        $id = $this->request->getVar('id');
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_produk' => 'required',
            'harga' => 'required|decimal',
            'stok' => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
        ];

        $this->produkmodel->update($id, $data);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui.'
        ]);
    }


}