<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $siswa;
    public function __construct()
    {
        $this->siswa = new AdminModel();
    }
    public function index()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // login logic

        $dataSiswa = $this->siswa->where('username', $username)->first();

        if ($dataSiswa) {
            // cek password
            $pass = $dataSiswa['password'];

            if ($pass == $password) {
                // set session
                $data = [
                    'status' => 'success',
                    'message' => 'Login Berhasil',
                    'nama' => $dataSiswa['nama'],
                    'nis' => $dataSiswa['username']

                ];

                return $this->response->setJSON($data);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => "NIS atau Kata Sandi Salah"
                ]);
            }
        }
    }
}
