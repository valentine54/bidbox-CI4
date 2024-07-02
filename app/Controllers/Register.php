<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Register extends BaseController
{
    public function index()
    {
        return view('register');
    }



    public function process()
    {
        helper(['form', 'url']);

        // Validate input fields
        $validationRules = [
            'Name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|matches[password]',
            'contact' => 'required|min_length[10]|max_length[15]',
        ];

        if (!$this->validate($validationRules)) {
            // Validation failed, redirect to register page with errors
            return redirect()->to('register')->withInput()->with('validation', $this->validator);
        }

        $defaultProfilePicture = 'uploads/default_user.jpg';

        // Save user data to database
        $model = new UserModel();
        $data = [
            'Name' => $this->request->getVar('Name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'contact' => $this->request->getVar('contact'),
            'profile_picture' =>$defaultProfilePicture,
            'status' => 0, // Example status (you can adjust as needed)
            'activation_token' => bin2hex(random_bytes(16)),
        ];

        if ($model->save($data)) {
            // Send activation email
            if (!$this->sendActivationEmail($data['email'], $data['activation_token'])) {
                return redirect()->to('register')->with('error', 'Failed to send activation email. Please try again.');
            }

            // User registration successful, redirect to activation notice or login page
            return redirect()->to('activation_notice')->with('email', $data['email']);
        } else {
            // Database save failed, handle accordingly
            return redirect()->to('register')->with('error', 'Registration failed. Please try again.');
        }
    }




    public function activate($token)
    {
        $model = new UserModel();
        $user = $model->where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->to('login')->with('error', 'Invalid activation token.');
        }

        $model->update($user['id'], ['status' => 1, 'activation_token' => null]);

        return redirect()->to('login')->with('success', 'Activation successful! Proceed to login.');
    }

    private function sendActivationEmail($email, $token)
    {
        $emailConfig = [
            'protocol' => 'smtp', // The mail sending protocol
            'SMTPHost' => 'smtp.gmail.com', // SMTP Server Hostname
            'SMTPUser' => 'kellygituka@gmail.com', // SMTP Username
            'SMTPPass' => 'phbs bqbz qtmz vtkg', // SMTP Password (App Password for 2FA)
            'SMTPPort' => 587, // SMTP Port
            'SMTPCrypto' => 'tls', // Encryption method
            'mailType' => 'html', // Type of mail, either 'text' or 'html'
            'charset' => 'UTF-8', // Character set
            'newline' => "\r\n" // Newline character
        ];

        $emailService = \Config\Services::email();
        $emailService->initialize($emailConfig);

        $emailService->setTo($email);
        $emailService->setSubject('Account Activation');

        $message = "
    <html>
    <head>
        <style>
            .email-container {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: auto;
            }
            .email-header {
                background-color: #995fd5;
                color: white;
                padding: 10px;
                border-radius: 5px 5px 0 0;
                text-align: center;
            }
            .email-body {
                padding: 20px;
                background-color: white;
                border-radius: 0 0 5px 5px;
                color: black;
            }
            .button-container {
                text-align: center;
                margin-top: 20px;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                color: white !important;
                background-color: #7e3fd7;
                border: none;
                border-radius: 5px;
                text-decoration: none;
            }
            .button:hover {
                background-color: #432188;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='email-header'>
                <h1>Account Activation</h1>
            </div>
            <div class='email-body'>
               <h3>Welcome to BidBox!</h3>
               <p>Thank you for joining our community.We are excited to have you join us.Be ready to add luxury to your collections like never before.</p>
                <p>To officially join us please click the button below to activate your account:</p>
               <div class='button-container'>
                    <a href='".base_url('activate/' . $token)."' class='button' style='color: white;'>Activate Account</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";

        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Email sending failed: ' . $emailService->printDebugger(['headers']));
            return false;
        }
        return true;
    }




}
