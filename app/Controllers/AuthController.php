<?php

namespace App\Controllers;

use App\Models\PenggunaModel;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new PenggunaModel();

        $username = $this->request->getPost('nama_pengguna');
        $password = $this->request->getPost('kata_sandi');

        $user = $model->where('nama_pengguna', $username)->first();

        if ($user) {
            if (password_verify($password, $user['kata_sandi'])) {
                $ses_data = [
                    'id'            => $user['id'],
                    'nama_pengguna' => $user['nama_pengguna'],
                    'peran'         => $user['peran'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                $session->setFlashdata('success', 'Selamat datang kembali, ' . $user['nama_pengguna'] . '!');
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Kata sandi salah.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Nama pengguna tidak ditemukan.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
