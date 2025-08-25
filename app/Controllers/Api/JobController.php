<?php

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Models\JobModel;

class JobController extends ResourceController
{
    protected $modelName = JobModel::class;
    protected $format    = 'json';

    // GET /api/jobs → semua job
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // GET /api/jobs/active → hanya job aktif
    public function aktif()
    {
        return $this->respond($this->model->where('status', 'aktif')->findAll());
    }

    // GET /api/jobs/inactive → hanya job nonaktif
    public function nonaktif()
    {
        return $this->respond($this->model->where('status', 'nonaktif')->findAll());
    }

    // GET /api/jobs/{id}
    public function show($id = null)
    {
        $job = $this->model->find($id);
        return $job ? $this->respond($job) : $this->failNotFound();
    }

    // POST /api/jobs
    public function create()
    {
        $data = $this->request->getJSON(true);
        $data['status'] = $data['status'] ?? 'nonaktif'; // default nonaktif
        $this->model->insert($data);
        return $this->respondCreated($data);
    }

    // PUT /api/jobs/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        $this->model->update($id, $data);
        return $this->respondUpdated($data);
    }

    // DELETE /api/jobs/{id}
    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respondDeleted(['status' => 'deleted']);
    }

    // ✅/❌ update status
    public function updateStatus($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['status'])) {
            return $this->failValidationErrors('Status wajib diisi (aktif/nonaktif)');
        }

        $job = $this->model->find($id);
        if (!$job) {
            return $this->failNotFound("Job tidak ditemukan");
        }

        $this->model->update($id, ['status' => $data['status']]);

        return $this->respond([
            'status' => 'success',
            'message' => "Job {$id} berhasil diubah ke {$data['status']}"
        ]);
    }
}
