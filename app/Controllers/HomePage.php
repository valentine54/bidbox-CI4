<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class HomePage extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            // Redirect to the login page
            return redirect()->to('/login');
        }
        echo view('dashboard');
    }


    public function unlock()
    {
        $session = session();
        $user = $session->get('user');
        $model = new UserModel();

        $input = $this->request->getJSON();
        $password = $input->password;

        $userData = $model->find($user['id']);

        if ($userData && password_verify($password, $userData['password'])) {
            // Password is correct
            return $this->response->setJSON(['success' => true]);
        }

        // Invalid password
        return $this->response->setJSON(['success' => false]);
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();

        return redirect()->to('/login');
    }
}
