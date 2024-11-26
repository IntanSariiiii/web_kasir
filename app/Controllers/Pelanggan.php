<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PelangganModel;

class Pelanggan extends BaseController
{
    protected $Pelangganmodel;

    public function __construct()
    {
        $this->Pelangganmodel = new PelangganModel();
    }
    public function index()
    {
        return view('data_pelanggan/v_pelanggan');
    }

    public function simpan_Pelanggan()
    {
        //validasi input dari AJAX
        // $validation = \Config\Services::validation();

        // $validation->setRules([
        //     'nama_Pelanggan'   => 'required',
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
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat' => $this->request->getVar('alamat'),
            'nomor_tlp'  => $this->request->getVar('nomor_tlp'),
        ];

        $this->Pelangganmodel->save($data);

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Data Pelanggan berhasil disimpan',
        ]);
    
    }

    public function tampil_pelanggan()
    {
        $data = $this->Pelangganmodel->findAll(); // Pastikan ini mengembalikan array
        return $this->response->setJSON([
            'status' => 'success',
            'pelanggan' => $data
        ]);
    }


    public function hapus($id)
    {
        $model = new PelangganModel();

        // Periksa apakah ID valid
        if ($model->find($id)) {
            // Hapus pelanggan berdasarkan ID
            if ($model->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Pelanggan berhasil dihapus.']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus pelanggan.']);
            }
        }

        // ID tidak ditemukan
        return $this->response->setJSON(['success' => false, 'message' => 'Pelanggan tidak ditemukan.']);
    }
   
    public function edit($id)
    {
        $data = $this->Pelangganmodel->find($id);
        if ($data) {
            return $this->response->setJSON(['status' => 'success', 'produk' => $data]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan.']);
        }
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'nomor_tlp' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat' => $this->request->getVar('alamat'),
            'nomor_tlp' => $this->request->getVar('nomor_tlp'),
        ];

        $this->Pelangganmodel->update($id, $data);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui.'
        ]);
    }


}