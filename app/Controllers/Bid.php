<?php
namespace App\Controllers;

use App\Models\BidModel;

class Bid extends BaseController
{
    public function placeBid()
    {
        $bidModel = new BidModel();
        $data = [
            'product_id' => $this->request->getPost('product_id'),
            'bidder_id' => session()->get('bidder_id'),
            'amount' => $this->request->getPost('amount'),
            'status' => 'active'
        ];
        $bidModel->save($data);
        return redirect()->to('/yourbids');
    }
}
