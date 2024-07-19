<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Content-Type: application/json');

class Api extends CI_Controller {

    // Load configuration in your controller or model
$this->load->config('mpesa');

// Retrieve consumer key and secret
$consumerKey = $this->config->item('MPESA_CONSUMER_KEY');
$consumerSecret = $this->config->item('MPESA_CONSUMER_SECRET');


    public function __construct() {
        parent::__construct();
        // Load necessary models and libraries
        $this->load->model('PaymentModel');
        
        // Load the custom configuration file
        $this->config->load('mpesa');
    }

    public function stk() {
        try {
            // Get POST data
            $bid_id = $this->input->post('bid_id');
            $amount = $this->input->post('amount');
            $phone = $this->input->post('phone');

            // Your existing API setup code here
            // Ensure $BusinessShortCode, $Password, $Timestamp are defined

            // Prepare payment payload
            $payload = array(
                "BusinessShortCode" => $BusinessShortCode,
                "Password" => $Password,
                "Timestamp" => $Timestamp,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => $amount,
                "PartyA" => $phone,
                "PartyB" => $BusinessShortCode,
                "PhoneNumber" => $phone,
                "CallBackURL" => $this->config->item('LNMO_CALLBACK_URL') . uniqid(), // Use the configured URL
                "AccountReference" => uniqid(),
                "TransactionDesc" => "Payment for bid ID: " . $bid_id
            );

            $url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

            // Make API call to initiate STK Push
            $response = $this->api->lipa_na_mpesa_online($url, json_encode($payload));

            // Handle response as needed
            $data = array(
                'status' => 'success',
                'bid_id' => $bid_id,
                'amount' => $amount,
                'phone' => $phone,
                'response' => json_decode($response, true)
            );

            // Store transaction details in database
            $transaction_data = array(
                'mpesaReceiptNumber' => '', // Retrieve from M-Pesa response callback
                'amount' => $amount,
                'phoneNumber' => $phone
            );

            $this->PaymentModel->save_transaction($transaction_data);

            echo json_encode($data);
        } catch (Exception $e) {
            // Handle exceptions and return an error response
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function lnmo() {
        // Handle M-Pesa callback (lnmo.php functionality)
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['Body']['stkCallback']['ResultCode']) && $data['Body']['stkCallback']['ResultCode'] == 0) {
            $mpesaReceiptNumber = $data['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            $amount = $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
            $phoneNumber = $data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];

            // Store transaction details in database
            $transaction_data = array(
                'mpesaReceiptNumber' => $mpesaReceiptNumber,
                'amount' => $amount,
                'phoneNumber' => $phoneNumber
            );

            $this->PaymentModel->save_transaction($transaction_data);

            // Respond to M-Pesa with a success message
            echo json_encode(array(
                'ResultCode' => 0,
                'ResultDesc' => 'Payment received successfully.'
            ));
        } else {
            // Handle transaction failure
            echo json_encode(array(
                'ResultCode' => 1,
                'ResultDesc' => 'Payment failed.'
            ));
        }
    }
}
?>
