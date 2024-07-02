<?php
namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
public function edit()
{
    $user = session()->get('user');

    if (!$user) {
        // Handle case where user data is not found
        // You might redirect or show an error message
        return redirect()->to('logout'); // Example redirection
    }

return view('profile/edit', ['user' => $user]);
}

// In your update method of ProfileController

    public function update()
    {
        helper(['form', 'url']);

        $validationRules = [
            'Name' => 'required',
            'email' => 'required|valid_email',
            'contact' => 'required|min_length[10]|max_length[15]',
            'profile_picture' => 'permit_empty|uploaded[profile_picture]|max_size[profile_picture,1024]|is_image[profile_picture]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $userModel = new UserModel();
        $userId = session()->get('user')['id'];

        $data = [
            'Name' => $this->request->getVar('Name'),
            'email' => $this->request->getVar('email'),
            'contact' => $this->request->getVar('contact'),
        ];

        // Handle profile picture upload
        $profilePicture = $this->request->getFile('profile_picture');
        if ($profilePicture && $profilePicture->isValid()) {
            $newFileName = $this->request->getVar('Name') . '.' . $profilePicture->getExtension();
            $profilePicture->move(FCPATH . 'uploads', $newFileName); // Ensure FCPATH is correctly pointing to your root directory
            $data['profile_picture'] = 'uploads/' . $newFileName;
        }

        // Update user data in the database
        $userModel->update($userId, $data);

        // Send profile update email after successful update
        $email = $data['email']; // Use the updated email address

        if (!$this->sendProfileUpdateEmail($email)) {
            return redirect()->to('profile/edit')->with('error', 'Failed to send profile update email');
        }

        return redirect()->to('profile/edit')->with('success', 'Profile updated successfully');
    }

    private function sendProfileUpdateEmail($email)
    {
        $emailConfig = [
            'protocol' => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPUser' => 'kellygituka@gmail.com',
            'SMTPPass' => 'phbs bqbz qtmz vtkg',
            'SMTPPort' => 587,
            'SMTPCrypto' => 'tls',
            'mailType' => 'html',
            'charset' => 'UTF-8',
            'newline' => "\r\n"
        ];

        $emailService = \Config\Services::email();
        $emailService->initialize($emailConfig);

        $emailService->setTo($email);
        $emailService->setSubject('Profile Updated');

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
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='email-header'>
                <h1>Profile Updated</h1>
            </div>
            <div class='email-body'>
                <h3>Your Profile Has Been Updated</h3>
                <p>Dear User,</p>
                <p>We wanted to inform you that your profile details have been successfully updated. Changes will be fully seen one you log out and login again for verification</p>
                <p>If you did not make these changes, please contact our support team immediately.</p>
                <p>Thank you!</p>
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
