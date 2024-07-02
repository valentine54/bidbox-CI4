<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ApplicationModel;
use App\Models\UserModel;
class AdminController extends BaseController
{

    public function dashboard()
    {
        $userModel = new UserModel();
        $applicationModel = new ApplicationModel();


        $activeAccounts = $userModel->getUsersByStatus(1);
        $inactiveAccounts = $userModel->getUsersByStatus(0);
        $applications = $applicationModel->findAll();

        $data = [
            'activeAccounts' => $activeAccounts,
            'inactiveAccounts' => $inactiveAccounts,
            'applications' => $applications,
        ];

        return view('admin/dashboard', $data);
    }


    public function users($role = null)
    {
        $userModel = new UserModel();

        if ($role) {
            $users = $userModel->where('role', $role)->findAll();
        } else {
            $users = $userModel->findAll();
        }

        $data = [
            'users' => $users
        ];

        return view('admin/users', $data);

    }

    public function editUser($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login')); // Redirect to login if not authenticated
        }
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            // Handle case where user is not found, perhaps show an error or redirect
            return redirect()->to(site_url('admin/users'))->with('error', 'User not found.');
        }

        $data = [
            'user' => $user
        ];

        return view('admin/edit_user', $data);
    }

    public function deleteUser($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to(site_url('admin/users'))->with('success', 'User deleted successfully.');
    }

    public function updateUser($id)
    {
        $userModel = new UserModel();
        $data = [
            'Name' => $this->request->getPost('Name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'contact' => $this->request->getPost('contact')
        ];
        // Update the user record in the database
        if (!$userModel->update($id, $data)) {
            // Handle update failure
            return redirect()->back()->withInput()->with('error', 'Failed to update user.');
        }

        // Send email notification after successful update
        if ($this->sendUpdateNotificationEmail($data['email'])) {
            return redirect()->to(site_url('admin/users'))->with('success', 'User updated successfully and email sent.');
        } else {
            return redirect()->to(site_url('admin/users'))->with('warning', 'User updated successfully but email failed to send.');
        }

    }

    private function sendUpdateNotificationEmail($email)
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
        $emailService->setSubject('Your Account Details Updated');

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
                <h1>Account Update</h1>
            </div>
            <div class='email-body'>
                <h3>Your Account Details Have Been Updated</h3>
                <p>This is to notify you that your account details have been successfully updated.</p>
                <p>If you did not request this change, please contact our support team immediately.</p>
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


    public function updateRole($id)
    {
        $userModel = new UserModel();

        // Retrieve the existing user data
        $user = $userModel->find($id);

        if (!$user) {
            // Handle case where user is not found
            return redirect()->back()->with('error', 'User not found.');
        }

        // Prepare data for role update
        $data = [
            'role' => $this->request->getPost('role')
        ];

        // Update the user's role in the database
        if (!$userModel->update($id, $data)) {
            // Handle update failure
            return redirect()->back()->with('error', 'Failed to update user role.');
        }

        return redirect()->to(site_url('admin/users'))->with('success', 'User role updated successfully.');
    }


    public function roles()
    {
        $userModel = new UserModel();
        $defaultUsers = $userModel->getUsersByRole('user'); // Assuming you have this method in your UserModel

        $data = [
            'defaultUsers' => $defaultUsers,
        ];

        return view('admin/roles', $data); // Load the roles view with data
    }


    public function salesHistory()
    {
        return view('admin/sales_history');
    }

    public function index()
    {

        $applicationModel = new ApplicationModel();
        $data['applications'] = $applicationModel->findAll();
        return view('admin/applications', $data);
    }






    public function disapprove()
    {
        $json = $this->request->getJSON();
        $id = $json->id;
        $reason = $json->reason;

        $model = new ApplicationModel();
        $application = $model->find($id);

        if ($application) {
            $data = ['status' => 'disapproved', 'reason' => $reason];

            if ($model->update($id, $data)) {
                // Send disapproval email
                $this->sendDisapprovalEmail($application['email'], $application['applicant_name'], $reason);

                return $this->response->setJSON(['message' => 'Application disapproved successfully']);
            } else {
                return $this->response->setStatusCode(400)->setJSON(['message' => 'Failed to disapprove application']);
            }
        } else {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Application not found']);
        }
    }
    public function updateStatus()
    {
        $json = $this->request->getJSON();
        $id = $json->id;
        $status = $json->status;

        $model = new ApplicationModel();
        $application = $model->find($id);

        if ($application) {
            $data = ['status' => $status];

            if ($model->update($id, $data)) {
                // Send approval email if status is approved
                if ($status === 'approved') {
                    if ($this->sendApprovalEmail($application['email'])) {
                        return $this->response->setJSON(['message' => 'Status updated and approval email sent successfully']);
                    } else {
                        return $this->response->setStatusCode(400)->setJSON(['message' => 'Status updated but failed to send approval email']);
                    }
                }

                return $this->response->setJSON(['message' => 'Status updated successfully']);
            } else {
                return $this->response->setStatusCode(400)->setJSON(['message' => 'Failed to update status']);
            }
        } else {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Application not found']);
        }
    }

    private function sendApprovalEmail($email)
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
        $emailService->setFrom('kellygituka@gmail.com', 'Your Name'); // Adjust this to your preferred sender details
        $emailService->setSubject('Application Approved');

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
                background-color: #6d32ab;
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
                <h1>Application Approved</h1>
            </div>
            <div class='email-body'>
                <h3>Congratulations!</h3>
                <p>Your application has been approved. You are now a registered auctioneer on our platform.</p>
                <p>Feel free to login and start using our services.</p>
                <p>If you have any questions, please contact our support team.</p>
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




    private function sendDisapprovalEmail($email, $name, $reason)
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
        $emailService->setSubject('Application Disapproved');

        $message = "
        <html>
        <head>
            <style>
                .email-container { ... }
                .email-header { ... }
                .email-body { ... }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='email-header'>
                    <h1>Application Disapproved</h1>
                </div>
                <div class='email-body'>
                <h3>Dear : {$name}</h3>
                    <h3>We regret to inform you...</h3>
                    <p>Your application has been disapproved.</p>
                    <p>Reason: <br>{$reason}</p>
                    <p>If you have any questions, please contact our support team.</p>
                </div>
            </div>
        </body>
        </html>
    ";

        $emailService->setMessage($message);

        if (!$emailService->send()) {
            echo $emailService->printDebugger(['headers']);
            log_message('error', 'Email sending failed: ' . $emailService->printDebugger(['headers']));
            return false;
        }
        return true;
    }

    // Controller: Admin.php


    public function update_status_direct()
    {
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $status = $request->getPost('status');

        if (empty($id) || empty($status)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid input']);
        }

        // Example code to update the status
        $model = new \App\Models\ApplicationModel();
        $updateData = [
            'status' => $status
        ];

        if ($model->update($id, $updateData)) {
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Status updated successfully']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to update status']);
        }
    }






}
