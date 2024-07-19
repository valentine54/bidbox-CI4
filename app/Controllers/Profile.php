<?php
namespace App\Controllers;

use App\Models\BidderModel;

class Profile extends BaseController
{
    public function index()
    {
        $bidderModel = new BidderModel();
        $data['bidder'] = $bidderModel->find(session()->get('bidder_id'));
        return view('profile', $data);
    }

    public function updateProfile()
    {
        $bidderModel = new BidderModel();
        $bidderId = session()->get('bidder_id');

        // Handle profile update
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];

        $bidderModel->update($bidderId, $data);
        return redirect()->to('profile');
    }

    public function updateProfileImage()
    {
        $bidderModel = new BidderModel();
        $bidderId = session()->get('bidder_id');

        // Handle profile image upload
        if ($image = $this->request->getFile('profile_image')) {
            if ($image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move(WRITEPATH . 'uploads/profile_images', $newName);

                $data = ['profile_image' => $newName];
                $bidderModel->update($bidderId, $data);
            }
        }

        return redirect()->to('profile');
    }
}
