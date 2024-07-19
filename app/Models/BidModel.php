<?php

namespace App\Models;

use CodeIgniter\Model;

class BidModel extends Model
{
    protected $table = 'bids';

    public function getApprovedBidsByBidder($bidder_id)
    {
        return $this->select('bids.*, products.name as product_name, products.picture')
                    ->join('products', 'bids.product_id = products.id')
                    ->where('bids.bidder_id', $bidder_id)
                    ->where('bids.status', 'approved')
                    ->findAll();
    }
}
