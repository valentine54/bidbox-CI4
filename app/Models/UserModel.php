<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['Name', 'email', 'password','contact','profile_picture','role','status','activation_token','reset_token'];
    protected $returnType = 'array';

    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }
    public function getUsersByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }


}
