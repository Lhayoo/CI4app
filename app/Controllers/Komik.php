<?php

namespace App\Controllers;

use App\Models\komikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new komikModel();
    }
    public function index()
    {
        // $komikModel = new \App\Models\komikModel(); cara lama
        // $komik = $this->komikModel->findAll();
        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        // $komik = $this->komikModel->where(['slug' => $slug])->first(); cara lama
        $komik = $this->komikModel->getKomik($slug);
        $data = [
            'title' => 'Detail Komik',
            'komik' => $komik
        ];
        // jika tidak ada komik di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan.');
        }
        return view('komik/detail', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];
        return view('komik/tambah', $data);
    }
    public function save()
    {
        // validate input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar.'
                ]
            ],
            'penulis' => [
                'rules' => 'required[penulis]',
                'errors' => [
                    'required' => '{field} komik harus diisi.'
                ]
            ],
            'penerbit' => [
                'rules' => 'required[penerbit]',
                'errors' => [
                    'required' => '{field} komik harus diisi.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'required' => '{field} komik harus diisi.',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('komik/tambah/')->withInput();
        }
        // get file
        $file_sampul = $this->request->getFile('sampul');

        // jika ingin nama file random
        // $nama_sampul = $file_sampul->getRandomName();
        // $file_sampul->move('img', $nama_sampul);

        // jik tidak ada file yang diupload
        // if ($file_sampul->getError() == 4) {
        //     $nama_sampul = 'default.jpg';
        // } else {
        //     // generate nama sampul random
        //     $nama_sampul = $file_sampul->getRandomName();
        //     // pindahkan file ke folder img
        //     $file_sampul->move('img', $nama_sampul);
        // }

        // pindah file ke public img
        $file_sampul->move('img');
        // nama file
        $nama_sampul = $file_sampul->getName();

        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => url_title($this->request->getVar('judul'), '-', true),
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $nama_sampul
        ]);
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to('/komik');
    }
    public function delete($id)
    {
        // get sampul by id
        $sampul = $this->komikModel->find($id);
        // pengecekan sampul
        if ($sampul['sampul'] != 'default.jpg') {
            // hapus gambar
            unlink('img/' . $sampul['sampul']);
        }
        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/komik/');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];
        return view('komik/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }
        // validate input
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar.'
                ]
            ],
            'penulis' => [
                'rules' => 'required[penulis]',
                'errors' => [
                    'required' => '{field} komik harus diisi.'
                ]
            ],
            'penerbit' => [
                'rules' => 'required[penerbit]',
                'errors' => [
                    'required' => '{field} komik harus diisi.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput();
        }
        // get sampul
        $fileSampul = $this->request->getFile('sampul');
        // cek gambar, apakah tetap gambar lama
        $sampulLama = $this->request->getVar('lama');
        // cek sampul
        if ($fileSampul->getError() == 4) {
            $namaSampul = $sampulLama;
        } else {
            // random name
            $namaSampul = $fileSampul->getRandomName();
            // move to img
            $fileSampul->move('img', $namaSampul);
            // hapus file lama
            unlink('img/' . $sampulLama);
        }
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => url_title($this->request->getVar('judul'), '-', true),
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);
        session()->setFlashdata('pesan', 'Data berhasil diedit.');
        return redirect()->to('/komik');
    }
}