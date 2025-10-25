<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukController extends BaseController
{
    public function index()
    {
        return view('admin/produk/index');
    }

    public function kategori()
    {
        $data = [
            'title' => 'Daftar Kategori Produk',
            'data_kategori' => $this->KategoriModel->findAll()
        ];
        return view('admin/produk/kategori',$data);
    }

    public function simpan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'nama_kategori' => esc($this->request->getPost('nama_kategori'))
        ];

        $this->KategoriModel->insert($data);

        return redirect()->back()->with('success','Data Kategori Produk Berhasil Ditambahkan');
    }

    public function ubah($id_kategori)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'nama_kategori' => esc($this->request->getPost('nama_kategori'))
        ];

        $this->KategoriModel->update($id_kategori,$data);

        return redirect()->back()->with('success','Data Kategori Produk Berhasil Di-update');
    }
}
