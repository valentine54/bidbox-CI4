<?php
namespace App\Controllers;

use App\Models\BidModel;

class YourBids extends BaseController
{
    public function index()
    {
        $bidModel = new BidModel();
        $data['bids'] = $bidModel->select('bids.*, products.name as product_name, products.category_id, products.minimum_price, categories.name as category_name')
            ->join('products', 'products.id = bids.product_id')
            ->join('categories', 'categories.id = products.category_id')
            ->where('bids.bidder_id', session()->get('bidder_id'))
            ->findAll();

        return view('yourbids', $data);
    }

    public function withdraw($bid_id)
    {
        $bidModel = new BidModel();
        $bidModel->delete($bid_id);
        return redirect()->to('/yourbids');
    }
}
