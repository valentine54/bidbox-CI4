<?php

namespace App\Controllers;

use App\Libraries\API; // Assuming API class is defined in Libraries folder or adjust namespace accordingly

class Mpesa extends BaseController
{
    public function initiateSTKPush()
    {
        // Assuming you handle the POST request to initiate STK push
        if ($this->request->getMethod() == 'post') {
            // Get phone number from POST data
            $phone = $this->request->getPost('phone');

            // Create an instance of your API class (adjust namespace and class name)
            $mpesa = new API();
            
            // Call method to initiate STK push (modify according to your API class)
            $response = $mpesa->initiateSTKPush($phone);

            // Return JSON response
            return $this->response->setJSON($response);
        } else {
            // Handle invalid requests
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
    }
    public function handleMpesaCallback()
    {
        // Get order ID from query string
        $orderId = $this->request->getGet('oid');

        // Get raw data from input stream
        $data = file_get_contents("php://input");

        // Write data to a file (example: JSON format)
        $filePath = WRITEPATH . 'uploads/orders/' . $orderId . '-payment.json';
        $h = fopen($filePath, "a");
        fwrite($h, $data);
        fclose($h);

        // Send HTTP response (optional, but recommended)
        return $this->response->setStatusCode(200);
    }
}
