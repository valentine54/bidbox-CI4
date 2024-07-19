<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BidModel;
use App\Models\ProductModel;
use App\Models\UserModel; // Add UserModel here if used
use App\Models\CartModel; // Add CartModel here if used
use App\Models\BidderModel; // Add BidderModel here if used
use App\Models\CategoryModel; 
use App\Models\DeliveryModel; 

class Bidder extends BaseController
{
    public function sidebar()
    {
        // Fetch user details
        $bidder_id = session()->get('bidder_id', 1); // Default to 1 if not set
        $userModel = new UserModel();
        $user = $userModel->find($bidder_id);

        // Fetch cart count (example logic)
        $cartModel = new CartModel();
        $cart_count = $cartModel->where('bidder_id', $bidder_id)->countAllResults(); // Example logic to fetch cart count

        // Prepare data to pass to the view
        $data = [
            'user_name' => $user['Name'] ?? 'User Name Not Found',
            'user_email' => $user['email'] ?? 'User Email Not Found',
            'user_contact' => $user['contact'] ?? '',
            'cart_count' => $cart_count,
        ];
        // Assuming you have retrieved $user_name and $user_email from session or database
        $data['user_name'] = $user_name;
        $data['user_email'] = $user_email;
        $data['user_contact'] = $user_contact;


        // Load view with data
        return view('bidder/sidebar', $data);
    }

    // Example of loading models via dependency injection in controller constructor
public function __construct()
{
    $this->productModel = new ProductModel();
    $this->userModel = new UserModel();
}

    
// Bidder Controller

// BidderController.php

public function index()
    {
        // Fetch products from the database using ProductModel
        $productModel = new ProductModel(); // Adjust this based on your actual model
        $products = $productModel->findAll(); // Adjust this based on your actual product retrieval logic

        // Fetch user details based on bidder_id from session
        $bidder_id = session()->get('bidder_id') ?? 1; // Default to 1 if not set
        $bidderModel = new BidderModel(); // Adjust this based on your actual model
        $user = $bidderModel->find($bidder_id);

        if (!$user) {
            // Handle case where user is not found
            // For example, redirect to login or handle error
            return redirect()->to('/login'); // Example redirection to login page
        }

        // Example logic to handle user data
        $user_name = $user['Name'] ?? 'Default Name';
        $user_email = $user['email'] ?? 'default@example.com';
        $user_contact = $user['contact'] ?? 'No contact';
        $profile_image = $user['profile_image'] ?? 'defaultBidder.jpeg'; // Default profile image
        
        // Example logic to fetch cart count (replace with your actual logic)
        $cart_count = 10; // Replace with your actual logic to fetch cart count

        // Check if the form is submitted for profile update
        if ($this->request->getMethod() === 'post') {
            // Retrieve form data
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $contact = $this->request->getPost('contact');

            // Handle profile image upload if provided
            $profileImage = $this->request->getFile('profile_image');
            if ($profileImage->isValid() && !$profileImage->hasMoved()) {
                $newName = $profileImage->getRandomName();
                $profileImage->move('./public/uploads/', $newName);

                // Update profile image field in database using BidderModel
                $bidderModel->updateProfileImage($bidder_id, $newName);
            }

            // Update other user profile information
            $bidderModel->updateProfile($bidder_id, $name, $email, $password, $contact);

            // Redirect to index page or reload the view as needed
            return redirect()->to('/bidder/index'); // Redirect to the index method
        }

        // Prepare data to pass to the view
        $data = [
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_contact' => $user_contact,
            'profile_image' => $profile_image,
            'cart_count' => $cart_count,
            'products' => $products,
        ];

        // Load the view with data
        return view('bidder/index', $data);
    }
    public function yourBids()
{
    // Fetch current bidder ID from session
    $bidder_id = session()->get('bidder_id') ?? 1; // Default to 1 if not set
    $user = $this->userModel->find($bidder_id);
    $profile_image = $user['profile_image'] ?? 'defaultBidder.jpeg';

    // Load necessary models using the model() method
    $bidModel = new BidModel();
    $productModel = new ProductModel(); // Adjust model name as per your structure

    // Fetch bids for the current bidder
    $bids = $bidModel->getBidsByBidder($bidder_id);

    // Prepare data to pass to the view
    $data = [
        'bids' => $bids,
    ];

    // Load the view file 'your_bids.php' from the 'bidder' folder
    return view('bidder/your_bids', $data);
}




    public function placeBid()
    {
        $bidModel = new BidModel();
        $bidderModel = new BidderModel();

        $bidder_id = $this->request->getPost('bidder_id');
        $product_id = $this->request->getPost('product_id');
        $amount = $this->request->getPost('amount');

        // Check if bidder exists
        $bidder = $bidderModel->find($bidder_id);
        if ($bidder) {
            $data = [
                'product_id' => $product_id,
                'bidder_id' => $bidder_id,
                'amount' => $amount,
                'status' => 'awaiting_approval'
            ];

            if ($bidModel->insert($data)) {
                return redirect()->to('/yourbids?bidder_id=' . $bidder_id);
            } else {
                return redirect()->back()->with('error', 'Error placing bid.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid bidder ID.');
        }
    }
    public function delivery()
    {
        // Handle form submission
        if ($this->request->getMethod() == 'post') {
            $bidId = $this->request->getPost('bid_id');
            $amount = $this->request->getPost('amount');
            $streetAddress = $this->request->getPost('street_address');
            $city = $this->request->getPost('city');
            $zipcode = $this->request->getPost('zipcode');
            $contact = $this->request->getPost('contact');
            $phone = $this->request->getPost('phone');

            // Store the delivery data in the session
            session()->set('delivery', [
                'bid_id' => $bidId,
                'amount' => $amount,
                'street_address' => $streetAddress,
                'city' => $city,
                'zipcode' => $zipcode,
                'contact' => $contact,
                'phone' => $phone,
            ]);

            // Redirect to the payment page or handle payment logic
            return redirect()->to('/payment'); // Adjust the redirect URL as per your application flow
        }

        // Load the delivery form view with necessary data
        $data = [
            'bid_id' => session('delivery.bid_id'), // Fetch bid_id from session
            'amount' => session('delivery.amount'), // Fetch amount from session
        ];

        return view('bidder/delivery', $data); // Adjust view path as per your structure
    }
    
    public function approvedBids()
    {
        // Fetch current bidder ID from session
        $bidder_id = session()->get('bidder_id') ?? 1; // Default to 1 if not set

        // Load necessary models using the model() method
        $bidModel = new BidModel();

        // Fetch approved bids for the current bidder
        $approvedBids = $bidModel->getApprovedBidsByBidder($bidder_id);

        // Prepare data to pass to the view
        $data = [
            'approvedBids' => $approvedBids,
        ];

        // Load the view file 'approved_bids.php' from the 'bidder' folder
        return view('bidder/approved_bids', $data);
    }
     public function categories()
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        $categories = $categoryModel->findAll();
        $products = [];

        $selectedCategory = $this->request->getPost('category_id');
        if ($selectedCategory) {
            $products = $productModel->where('category_id', $selectedCategory)->findAll();
        }

        return view('bidder/categories', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
