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
                    return redirect()->to('/dashboard');
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
            'email' => $user['email'],
            // Add more user data if needed
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

    private function sendPasswordResetEmail($email, $token)
    {
        $emailConfig = [
            'protocol' => 'smtp', // The mail sending protocol
            'SMTPHost' => 'smtp.gmail.com', // SMTP Server Hostname
            'SMTPUser' => 'wvalentinem@gmail.com', // SMTP Username
            'SMTPPass' => 'fckn itor bojf ywvu', // SMTP Password (App Password for 2FA)
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
        $message = "<p>Please click the link below to reset your password:</p>";
        $message .= "<p><a href='".base_url('reset-password/' . $token)."'>Reset Password</a></p>";
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
