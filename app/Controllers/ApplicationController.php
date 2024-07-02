<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use CodeIgniter\Controller;

class ApplicationController extends Controller
{
    public function merchant()
    {
        return view('applications/merchant');
    }

    public function auctioneer()
    {
        return view('applications/auctioneer');
    }

    public function submit()
    {
        $model = new ApplicationModel();

        $file = $this->request->getFile('documents');
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = FCPATH . 'uploads'; // Path to the 'uploads' directory in 'public'

            // Ensure the 'uploads' directory exists
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }

            $file->move($filePath, $fileName);

            $data = [
                'applicant_name' => $this->request->getPost('applicant_name'),
                'email' => $this->request->getPost('email'),
                'type' => $this->request->getPost('type'),
                'message' => $this->request->getPost('message'),
                'documents' => $fileName,
                'status' => 'awaiting_approval',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $applicationId = $model->insert($data);

            if ($applicationId) {
                $application = $model->find($applicationId);

                if ($this->sendApplicationReceivedEmail($application['email'])) {
                    return redirect()->to('/')->with('message', 'Application submitted and notification email sent.');
                } else {
                    return redirect()->back()->with('error', 'Failed to send notification email.');
                }
            } else {
                return redirect()->back()->with('error', 'Failed to submit application.');
            }
        }

        return redirect()->back()->withInput()->with('error', 'File upload failed');
    }


    private function sendApplicationReceivedEmail($email)
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
        $emailService->setSubject('Application Received');

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
                    <h1>Application Received</h1>
                </div>
                <div class='email-body'>
                    <h3>Your Application Has Been Received</h3>
                    <p>Thank you for your application. We have successfully received it and will process it shortly.</p>
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

}
