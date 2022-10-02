<?php
namespace App\Controllers;
class Contact extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contact',
        ];
        return view('contact/index', $data);
    }
}