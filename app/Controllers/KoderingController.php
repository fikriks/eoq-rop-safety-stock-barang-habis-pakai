<?php

namespace App\Controllers;

use App\Models\KoderingModel;

class KoderingController extends BaseController
{
    protected $koderingModel;

    public function __construct()
    {
        $this->koderingModel = new KoderingModel();
    }

    public function index()
    {
        $data = [
            'kodering' => $this->koderingModel->findAll(),
        ];
        return view('kodering/index', $data);
    }
}
