<?php

namespace App\Controllers;

use App\Models\BidModel;
use App\Models\ProductModel;

class ApprovedBids extends BaseController
{
    public function index($bidder_id)
    {
        $bidModel = new BidModel();
        $productModel = new ProductModel();

        $approvedBids = $bidModel->getApprovedBidsByBidder($bidder_id);

        return view('approved_bids', ['approvedBids' => $approvedBids]);
    }
}
