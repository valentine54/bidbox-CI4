<?php

namespace App\Models;

use CodeIgniter\Model;

class BidModel extends Model
{
    protected $table = 'bids';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item', 'bidder', 'amount', 'status'];
}

