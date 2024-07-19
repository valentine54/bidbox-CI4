<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Your users table name
    protected $primaryKey = 'id'; // Primary key of the users table

    protected $allowedFields = ['Name', 'email', 'contact']; // Columns that can be manipulated


}
