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
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|matches[password]',
            'contact' => 'required|min_length[10]|max_length[15]',
            'age' => 'required|integer',
            'role' => 'required|in_list[admin,bidder,seller,auctioneer]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();

            // Check if there is a specific error for password confirmation
            $passwordConfirmationError = isset($errors['confirm_password']) ? $errors['confirm_password'] : '';

            return redirect()->to('register')->withInput()->with('errors', $errors)->with('password_confirmation_error', $passwordConfirmationError);
        }

        $model = new UserModel();
        $activationToken = bin2hex(random_bytes(16));
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'contact' => $this->request->getPost('contact'),
            'age' => $this->request->getPost('age'),
            'role' => $this->request->getPost('role'),
            'status' => 0, // User is not active yet
            'activation_token' => $activationToken,
        ];

        if ($model->save($data)) {
            log_message('debug', 'User registered: ' . json_encode($data));
            if ($this->sendActivationEmail($data['email'], $activationToken)) {
                // Redirect to the activation notice page with the email address
                return redirect()->to('activation_notice')->with('email', $data['email']);
            } else {
                log_message('error', 'Failed to send activation email for user: ' . $data['email']);
                return redirect()->to('register')->with('error', 'Failed to send activation email. Please try again.');
            }
        } else {
            log_message('error', 'Failed to save user data to database.');
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
        $message = "<p>Please click the link below to activate your account:</p>";
        $message .= "<p><a href='".base_url('activate/' . $token)."'>Activate Account</a></p>";
        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Email sending failed: ' . $emailService->printDebugger(['headers']));
            return false;
        }
        return true;
    }



}
