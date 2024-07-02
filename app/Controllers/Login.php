<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Define your admin credentials
        $adminEmail = 'admin234@gmail.com';
        $adminPassword = '@admin005'; // Ensure this is hashed
        $adminPasswordHash = password_hash($adminPassword, PASSWORD_DEFAULT);

        // Check if the submitted credentials match admin credentials
        if ($email === $adminEmail && password_verify($password, $adminPasswordHash)) {
            // Set admin user session data (you can customize this as needed)
            $adminData = [
                'id' => 0, // Example ID for admin
                'email' => $email,
                'role' => 'admin' // Example role for admin
            ];

            session()->set('user', $adminData);
            session()->set('isLoggedIn', true);

            // Redirect to admin dashboard or specific admin page
            return redirect()->to('/admin/users');
        }


        $model = new UserModel();
        $user = $model->where('email', $email)->first();

        if ($user) {
            // Compare the submitted password with the hashed password in the database
            if (password_verify($password, $user['password'])) {
                log_message('debug','Password verify result true');
                // Password is correct
                // Check if the user's account is activated
                if ($user['status'] == 1) {
                    // Set user data in session
                    $this->setUserSession($user);
                    // Redirect to dashboard
                    // Redirect based on user role
                    switch ($user['role']) {
                        case 'auctioneer':
                            return redirect()->to('/auctioneer/view-sellers');
                        case 'bidder':
                            return redirect()->to('/bidder/dashboard');
                        case 'seller':
                            return redirect()->to('/seller/dashboard');
                        default:
                            return redirect()->to('/dashboard'); // Default redirect for users with unspecified roles
                    }
                } else {
                    // User account is not activated
                    return redirect()->back()->with('error', 'Your account is not activated. Please check your email.');
                }
            } else {
                // Password is incorrect
                return redirect()->back()->with('error', 'Invalid password');
            }
        } else {
            // User not found
            return redirect()->back()->with('error', 'User not found');
        }
    }

    /**
     * Set user data in session.
     *
     * @param array $user
     * @return void
     */
    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'Name' => $user['Name'],
            'contact' => $user['contact'],
            'email' => $user['email'],
            'role' => $user['role'],
            'profile_picture' => $user['profile_picture'],

        ];

        session()->set('user', $data);
        session()->set('isLoggedIn', true);
    }
    public function forgotPasswordForm()
    {
        return view('forgot_password_form');
    }

    public function sendResetPasswordEmail()
    {
        $email = $this->request->getPost('email');

        $model = new UserModel();
        $user = $model->where('email', $email)->first();

        if ($user) {
            // Generate reset token
            $resetToken = bin2hex(random_bytes(16));

            // Update user's reset token in the database
            if ($user['reset_token'] === null) {
                // If reset token is null, use set() method to set the token
                $model->update($user['id'], ['reset_token' => $resetToken]);

            } else {
                // If reset token already exists, use update() method
                $model->update($user['id'], ['reset_token' => $resetToken]);
            }

            // Send password reset email
            // Send password reset email
            if ($this->sendPasswordResetEmail($email, $resetToken)) {
                return view('reset_link_sent', ['email' => $email]);
            } else {
                return redirect()->back()->with('error', 'Failed to send password reset email. Please try again.');
            }
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
    public function editProfile()
    {
        $userId = session()->get('user')['id']; // Retrieve user ID from session
        $model = new UserModel();
        $user = $model->find($userId); // Fetch user data from the database

        // Pass user data to the view
        return view('profile/edit', ['user' => $user]);
    }


    private function sendPasswordResetEmail($email, $token)
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
        $emailService->setSubject('Password Reset');

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
                <h1>Password Reset</h1>
            </div>
            <div class='email-body'>
                <h3>Reset Your Password</h3>
                <p>We received a request to reset your password. If you did not make this request, please ignore this email.</p>
                <p>Otherwise, you can reset your password using the button below:</p>
                <div class='button-container'>
                    <a href='".base_url('reset-password/' . $token)."' class='button'>Reset Password</a>
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




    public function resetPasswordForm($token)
    {
        // Check if token exists in the database
        $model = new UserModel();
        $user = $model->where('reset_token', $token)->first();

        if (!$user) {
            return redirect()->to('forgot-password')->with('error', 'Invalid reset token.');
        }

        return view('reset_password_form', ['token' => $token, 'email' => $user['email']]);
    }



    public function updatePassword()
    {
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $resetToken = $this->request->getPost('token');
        $email = $this->request->getPost('email');


        // Check if passwords match
        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        // Check if token exists in the database
        $model = new UserModel();
        $user = $model->where('reset_token', $resetToken)->first();


        if (!$user || $user['email'] !== $email) {
            return redirect()->to('forgot-password')->with('error', 'Invalid reset token.');
        }

        // Update user's password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $model->update($user['id'], ['password' => $hashedPassword, 'reset_token' => null]);

        return redirect()->to('login')->with('success', 'Password updated successfully. You can now login.');
    }

}
