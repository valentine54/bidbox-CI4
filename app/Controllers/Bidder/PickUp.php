<?php

namespace App\Controllers;

use App\Models\BidModel;
use App\Models\PickupModel;
use App\Models\PaymentModel;


class PickUp extends BaseController
{
    public function index()
    {
        return view('schedule_pickup');
    }

    public function submitPickup()
    {
        // Validate form data
        $validationRules = [
            'pickup-date' => 'required',
            'street-address' => 'required',
            'city' => 'required',
            'zipcode' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            // Handle validation errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Process form data
        $pickupData = [
            'bid_id' => // Get bid_id from session or form input,
            'pickup_date' => $this->request->getPost('pickup-date'),
            'address' => $this->request->getPost('street-address'),
            'city' => $this->request->getPost('city'),
            'zipcode' => $this->request->getPost('zipcode')
        ];

        $pickupModel = new PickupModel();
        $pickupModel->save($pickupData);

        // Update bid status to 'won' or 'lost' based on business logic
        $bidModel = new BidModel();
        $bidModel->update($bid_id, ['status' => 'won']); // Example: Update bid status

        // Redirect or show confirmation message
        return redirect()->to('/payments');
    }

    
}
