<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\FormLamaranModel;

class FormPelamarController extends ResourceController
{
    protected $modelName = FormLamaranModel::class;
    protected $format    = 'json';

    // === CRUD Lamaran ===
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function create()
    {
        $file = $this->request->getFile('upload_berkas');
        $newName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/berkas', $newName);
        }

        $this->model->insert([
            'id_job'       => $this->request->getPost('id_job'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'=> $this->request->getPost('tanggal_lahir'),
            'umur'         => $this->request->getPost('umur'),
            'alamat'       => $this->request->getPost('alamat'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'email'        => $this->request->getPost('email'),
            'pendidikan_terakhir' => $this->request->getPost('pendidikan_terakhir'),
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'jurusan'      => $this->request->getPost('jurusan'),
            'pengetahuan_perusahaan' => $this->request->getPost('pengetahuan_perusahaan'),
            'bersedia_cilacap' => $this->request->getPost('bersedia_cilacap'),
            'keahlian'     => $this->request->getPost('keahlian'),
            'tujuan_daftar'=> $this->request->getPost('tujuan_daftar'),
            'kelebihan'    => $this->request->getPost('kelebihan'),
            'kekurangan'   => $this->request->getPost('kekurangan'),
            'sosmed_aktif' => $this->request->getPost('sosmed_aktif'),
            'alasan_merekrut' => $this->request->getPost('alasan_merekrut'),
            'kelebihan_dari_yang_lain' => $this->request->getPost('kelebihan_dari_yang_lain'),
            'alasan_bekerja_dibawah_tekanan' => $this->request->getPost('alasan_bekerja_dibawah_tekanan'),
            'kapan_bisa_gabung' => $this->request->getPost('kapan_bisa_gabung'),
            'ekspektasi_gaji'   => $this->request->getPost('ekspektasi_gaji'),
            'alasan_ekspektasi' => $this->request->getPost('alasan_ekspektasi'),
            'upload_berkas'=> $newName
        ]);

        return $this->respondCreated(['message' => 'Lamaran berhasil dikirim']);
    }

    // === Tambahan untuk file berkas ===
    public function viewBerkas($filename)
    {
        $path = FCPATH . 'uploads/berkas/' . $filename;

        if (!file_exists($path)) {
            return $this->failNotFound('File tidak ditemukan.');
        }

        $mime = mime_content_type($path);

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setBody(file_get_contents($path));
    }

    public function downloadBerkas($filename)
    {
        $path = FCPATH . 'uploads/berkas/' . $filename;

        if (!file_exists($path)) {
            return $this->failNotFound('File tidak ditemukan.');
        }

        return $this->response->download($path, null);
    }
}
