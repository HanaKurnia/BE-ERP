<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FieldJobModel;

class FieldJobController extends BaseController
{
    protected $fieldJobModel;

    public function __construct()
    {
        $this->fieldJobModel = new FieldJobModel();
    }

    // === GET all field job ===
    public function index()
    {
        $data = $this->fieldJobModel->findAll();

        return $this->response->setJSON([
            'status' => 200,
            'data' => $data
        ]);
    }

    // === GET field job by id ===
    public function show($id = null)
    {
        $field = $this->fieldJobModel->find($id);

        if (!$field) {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 200,
            'data' => $field
        ]);
    }

    // === GET field job by Job ID ===
    public function byJob($jobId = null)
    {
        $data = $this->fieldJobModel->where('job_id', $jobId)->findAll();

        return $this->response->setJSON([
            'status' => 200,
            'data' => $data
        ]);
    }
}
