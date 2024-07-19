<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class TestEmailController extends Controller
{
    public function sendTestEmail()
    {
        $email = Services::email();
        $email->setFrom('wvalentinem@gmail.com', 'BidHub');
        $email->setTo('valentineciiku@gmail.com');
        $email->setSubject('Test Email');
        $email->setMessage('This is a test email.');

        if ($email->send()) {
            echo 'Email successfully sent';
        } else {
            echo 'Failed to send email';
            echo $email->printDebugger(['headers']);
        }
    }
}
