<?php
namespace App\Models;
use CodeIgniter\Model;

class JobModel extends Model {
    protected $table = 'job';
    protected $primaryKey = 'id_job';
    protected $allowedFields = ['posisi','deskripsi','tanggal_post','batas_lamaran', 'status'];
}
