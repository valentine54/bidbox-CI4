<?php namespace App\Models;

use CodeIgniter\Model;

class BidderModel extends Model
{
    protected $table = 'bidders'; // Your bidders table name
    protected $primaryKey = 'bidder_id'; // Primary key of the bidders table
    protected $allowedFields = ['bidder_id', 'user_id', 'profile_image']; // Add profile_image if necessary

    // Example method to fetch profile image
    public function updateProfileImage($bidder_id, $profile_image)
    {
        $data = [
            'profile_image' => $profile_image,
        ];

        $this->where('bidder_id', $bidder_id)
             ->set($data)
             ->update();
    }

    // Other methods as needed
}
