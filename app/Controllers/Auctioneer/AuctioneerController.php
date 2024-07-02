<?php

namespace App\Controllers\Auctioneer;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\BidModel;

class AuctioneerController extends Controller
{
    protected $bidModel; // Declare the property to hold BidModel instance

    public function __construct()
    {
        $this->bidModel = new BidModel(); // Initialize BidModel in constructor
    }
    public function viewSellers()
    {
        $userModel = new UserModel();
        $sellers = $userModel->where('role', 'seller')->findAll();

        return view('auctioneer/view_sellers', ['sellers' => $sellers]);
    }

    public function viewBidders()
    {
        $userModel = new UserModel();
        $bidders = $userModel->where('role', 'bidder')->findAll();

        return view('auctioneer/view_bidders', ['bidders' => $bidders]);
    }

    public function viewBids()
    {
        $bidModel = new BidModel();
        $bids = $bidModel->findAll();

        return view('auctioneer/view_bids', ['bids' => $bids]);
    }

    public function manageBids()
    {

        // Fetch bids with status 'awaiting approval'
        $data['bids'] = $this->bidModel->where('status', 'awaiting approval')->findAll();

        return view('auctioneer/manage_bids', $data);
    }

    public function updateBidStatus($id, $status)
    {
        $bidModel = new BidModel();
        $bidModel->update($id, ['status' => $status]);

        return redirect()->to('/auctioneer/manage-bids');
    }
}

