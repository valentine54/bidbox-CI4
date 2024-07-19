<?php
require __DIR__ . '/config.php';

class Mpesa {
    private $consumerKey;
    private $consumerSecret;
    private $baseUrl;

    public function __construct() {
        $this->consumerKey = CONSUMER_KEY;
        $this->consumerSecret = CONSUMER_SECRET;
        $this->baseUrl = BASE_URL;
    }

    public function authenticate() {
        $url = $this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response)->access_token;
    }

    public function stkPush($phone, $amount, $callbackUrl) {
        $url = $this->baseUrl . '/mpesa/stkpush/v1/processrequest';
        $token = $this->authenticate();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token, 'Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
            'BusinessShortCode' => BUSINESS_SHORTCODE,
            'Password' => base64_encode(BUSINESS_SHORTCODE . PASSKEY . date('YmdHis')),
            'Timestamp' => date('YmdHis'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => BUSINESS_SHORTCODE,
            'PhoneNumber' => $phone,
            'CallBackURL' => $callbackUrl,
            'AccountReference' => 'Bidder Payment',
            'TransactionDesc' => 'Payment for bid'
        ]));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}
