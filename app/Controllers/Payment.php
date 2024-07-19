<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load any necessary models or libraries here if needed
    }

    public function index() {
        // Handle callback from M-Pesa and insert into database
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Decode JSON data from M-Pesa callback
            $data = json_decode(file_get_contents('php://input'), true);

            // Example: Saving payment details to database
            $pdo = new PDO('mysql:host=localhost;dbname=bidbox', 'root', '');

            // Prepare SQL statement
            $stmt = $pdo->prepare("INSERT INTO payments (mpesaReceiptNumber, amount, phoneNumber) VALUES (?, ?, ?)");

            // Bind parameters and execute SQL statement
            $stmt->execute([
                $data['TransID'],         // M-Pesa Transaction ID
                $data['TransAmount'],     // Amount paid
                $data['MSISDN']           // Phone number of the payer
            ]);

            // Send response back to M-Pesa (Optional: Acknowledge receipt)
            header('Content-Type: application/json');
            echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Payment received successfully.']); // Modify response as per M-Pesa requirements
            exit;
        }
    }
}
