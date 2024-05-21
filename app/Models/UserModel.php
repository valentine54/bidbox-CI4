<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name', 'email', 'password','contact','age','role','status','activation_token','reset_token'];
    protected $returnType = 'array';
}