<?php

namespace App\Controllers;

use App\Models\orangModel;

class Orang extends BaseController
{
    protected $orangModel;
    public function __construct()
    {
        $this->orangModel = new orangModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;
        $data = [
            'title' => 'Daftar orang',
            // 'orang' => $this->orangModel->findAll(),
            'orang' => $this->orangModel->paginate(5, 'orang'),
            'pager' => $this->orangModel->pager,
            'currentPage' => $currentPage
        ];
        return view('/Orang/index', $data);
    }
}