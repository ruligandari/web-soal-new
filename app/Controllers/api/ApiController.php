<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PengaturanModel;
use App\Models\SiswaModel;
use App\Models\SoalModel;
use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    protected $soalModel;
    protected $siswaModel;
    protected $pengaturanModel;
    public function __construct()
    {
        $this->soalModel = new SoalModel();
        $this->siswaModel = new SiswaModel();
        $this->pengaturanModel = new PengaturanModel();
    }
    public function index()
    {
        $data = $this->soalModel->orderBy('id', 'DESC')->findAll();

        // return json
        return $this->response->setJSON($data);
    }
    public function readSoal()
    {
        $data = $this->soalModel->orderBy('id', 'DESC')->findAll();

        // return json
        return $this->response->setJSON($data);
    }

    public function readSoalById($id)

    {
        $data = $this->soalModel->find($id);
        if ($data) {
            // return json
            return $this->response->setJSON($data);
        }

        $data = [
            'message' => 'Data tidak ditemukan'
        ];
        // return json
        return $this->response->setJSON($data);
    }

    public function readSoalPost()
    {
        $id = $this->request->getPost('id');

        $data = $this->soalModel->find($id);
        // return json
        return $this->response->setJSON($data);
    }

    public function readNilai()
    {
        date_default_timezone_set('Asia/Jakarta');
        $nilai = $this->request->getPost('nilai');
        $nama_siswa = $this->request->getPost('nama_siswa');
        $nis = $this->request->getPost('nis');
        $waktu_pengerjaan = date('Y-m-d H:i:s');

        $data = [
            'nilai' => $nilai,
            'nama_siswa' => $nama_siswa,
            'waktu_pengerjaan' => $waktu_pengerjaan,
            'nis' => $nis
        ];

        try {
            // insert ke table siswa
            $this->siswaModel->insert($data);

            $returnData =
                [
                    'success' => true,
                    'message' => 'Data berhasil disimpan'
                ];

            // return json
            return $this->response->setJSON($returnData);
        } catch (\Exception $e) {
            $returnData =
                [
                    'success' => false,
                    'message' => $e->getMessage()
                ];

            // return json
            return $this->response->setJSON($returnData);
        }
    }

    public function skor()
    {
        $data = $this->siswaModel->findAll();

        // return json
        return $this->response->setJSON($data);
    }

    public function pengaturan()
    {
        $data = $this->pengaturanModel->where('id', 1)->first();

        $jumlah_soal = $data['jumlah_soal'];
        $datas = [
            'jumlah_soal' => $jumlah_soal
        ];

        // return json
        return $this->response->setJSON($datas);
    }

    public function getNilai($nis)
    {

        // cari niliai pengisian terbaru
        $data = $this->siswaModel->where('nis', $nis)->orderBy('id', 'DESC')->first();

        // return json
        return $this->response->setJSON($data);
    }
}
