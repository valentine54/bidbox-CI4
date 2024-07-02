<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['applicant_name', 'email', 'type', 'message', 'documents', 'status', 'created_at', 'reason'];

    public function getApplicationById($id)
    {
        return $this->find($id);
    }
}

