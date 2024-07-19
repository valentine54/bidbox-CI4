<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Delivery extends Controller
{
    public function index()
    {
        $session = session();

        $bid_id = $this->request->getGet('bid_id');
        $amount = $this->request->getGet('amount');

        if (!isset($bid_id) || !isset($amount)) {
            return 'Error: Missing bid ID or amount.';
        }

        $data = [
            'bid_id' => intval($bid_id),
            'amount' => floatval($amount),
        ];

        return view('bidder/delivery', $data);
    }

    public function process()
    {
        $session = session();

        $street_address = $this->request->getPost('street_address');
        $city = $this->request->getPost('city');
        $zipcode = $this->request->getPost('zipcode');
        $contact = $this->request->getPost('contact');
        $phone = $this->request->getPost('phone');

        $session->set('delivery', [
            'street_address' => $street_address,
            'city' => $city,
            'zipcode' => $zipcode,
            'contact' => $contact,
            'phone' => $phone,
        ]);

        return redirect()->to('/checkout');
    }

    public function payment()
    {
        // Implement your payment logic here
    }
}
