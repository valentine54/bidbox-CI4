<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\API\API; 

class StkController extends Controller
{
    public function initiateSTKPush()
    {
        // Load API class
        require_once APPPATH . '/api/api.php';
        $api = new \API(); // Adjust namespace as needed

        // Check if request method is POST
        if ($this->request->getMethod(true) === 'POST') {
            try {
                // Get POST data
                $bid_id = $this->request->getPost('bid_id');
                $amount = $this->request->getPost('amount');
                $phone = $this->request->getPost('phone');

                // Initiate STK Push
                $response = $api->initiateSTKPush($phone, $amount, $bid_id); // Modify API class to include this method

                // Prepare response data
                $data = [
                    'status' => 'success',
                    'bid_id' => $bid_id,
                    'amount' => $amount,
                    'phone' => $phone,
                    'response' => json_decode($response, true)
                ];

                // Return response as JSON
                return $this->response->setJSON($data);
            } catch (\Exception $e) {
                // Handle exceptions
                $errorData = [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
                
                return $this->response->setJSON($errorData);
            }
        } else {
            // Invalid request method
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method Not Allowed']);
        }
    }
}
