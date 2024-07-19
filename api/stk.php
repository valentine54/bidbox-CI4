<?php
require __DIR__ . '/api.php';

$phone = $_POST['phone'];
$amount = $_POST['amount'];
$bid_id = $_POST['bid_id'];
$callbackUrl = 'https://yourdomain.com/api/lnmo.php?oid=' . urlencode($bid_id);

$mpesa = new Mpesa();
$response = $mpesa->stkPush($phone, $amount, $callbackUrl);
echo json_encode(['status' => 'success', 'response' => $response]);
?>
