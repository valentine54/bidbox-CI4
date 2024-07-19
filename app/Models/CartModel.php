<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';

    public function getCartCount($bidder_id)
    {
        return $this->where('bidder_id', $bidder_id)->countAllResults();
    }
}
