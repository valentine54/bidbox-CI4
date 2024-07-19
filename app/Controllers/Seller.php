<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Controller;

class Seller extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $totalProducts = $db->table('products')->countAllResults();
        $totalCategories = $db->table('categories')->countAllResults();

        return view('seller/dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
        ]);
    }

    public function categories()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        return view('seller/categories', ['categories' => $categories]);
    }

    public function addCategory()
    {
        $categoryModel = new CategoryModel(); // Instantiate CategoryModel

        if ($this->request->getMethod() === 'post') {
            $name = $this->request->getPost('name');

            // Optionally, validate input
            $validationRules = [
                'name' => 'required|min_length[3]|max_length[255]' // Example validation rules
            ];

            if ($this->validate($validationRules)) {
                // Save to database
                $data = [
                    'name' => $name,
                ];

                try {
                    if ($categoryModel->insert($data)) {
                        // Success message
                        return redirect()->to('/seller/categories')->with('success', 'Category added successfully');
                    } else {
                        // Error message
                        return redirect()->back()->with('error', 'Failed to add category');
                    }
                } catch (\Exception $e) {
                    // Log the exception
                    log_message('error', 'Exception: ' . $e->getMessage());

                    // Display a generic error message
                    return redirect()->back()->with('error', 'An error occurred while adding the category');
                }
            } else {
                // Validation failed, reload the addcategory view with validation errors
                return view('seller/addcategory', ['validation' => $this->validator]);
            }
        }

        // Load view for adding category (initial load)
        return view('seller/addcategory');
    }

    public function viewProducts($categoryId)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        // Fetch category name
        $category = $categoryModel->find($categoryId);

        if ($category) {
            $categoryName = $category['name'];
            $products = $productModel->where('category_id', $categoryId)->findAll();

            return view('seller/view_products', [
                'categoryName' => $categoryName,
                'products' => $products
            ]);
        } else {
            // Handle case where category is not found
            return view('seller/category_not_found');
        }
    }

    public function products()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll(); // Fetch all products
    
        // Fetch categories
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll(); // Assuming you have a method to fetch all categories
    
        // Example: Fetch category name for each product (if stored in another table)
        foreach ($products as &$product) {
            // Fetch category name
            $category = $categoryModel->find($product['category_id']);
            if ($category) {
                $product['category_name'] = $category['name']; // Assuming 'name' is the column in 'categories' table
            } else {
                $product['category_name'] = 'Uncategorized'; // Example default if category not found
            }
        }
    
        return view('seller/products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
    
    // Example usage in a controller method
// Example usage in a controller or model
// Seller.php (Controller)

public function addProduct()
{
    // Process form submission
    if ($this->request->getMethod() === 'post') {
        $productModel = new ProductModel();

        // Calculate end time (56 hours from now)
        $endTime = date('Y-m-d H:i:s', strtotime('+56 hours'));

        // Retrieve form inputs
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'minimum_price' => $this->request->getVar('minimum_price'),
            'category_id' => $this->request->getVar('category_id'),
            'end_time' => $endTime,
        ];

        // Validate and save product
        if ($productModel->save($data)) {
            return redirect()->to('/seller/products')->with('success', 'Product added successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add product');
        }
    }

    // Load view for adding product
    $categoryModel = new CategoryModel();
    $categories = $categoryModel->findAll();
    return view('seller/add_product', ['categories' => $categories]);
}

public function saveProduct()
{
    $productModel = new ProductModel();

    // Collect form data into an array
    $data = [
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
        'minimum_price' => $this->request->getPost('minimum_price'),
        'category_id' => $this->request->getPost('category_id'),
    ];

    // Retrieve uploaded file
    $picture = $this->request->getFile('picture');

    if ($picture->isValid() && !$picture->hasMoved()) {
        // Move the uploaded file to the uploads directory
        $newName = $picture->getRandomName();
        $picture->move(ROOTPATH . 'public/uploads', $newName);

        // Save file path to the database
        $data['picture'] = 'uploads/' . $newName;
    } else {
        // Handle invalid or no file uploaded
        return redirect()->back()->with('error', 'Invalid file uploaded');
    }

    // Attempt to save the product data including the file path
    if ($productModel->save($data)) {
        // Redirect on success
        return redirect()->to('/seller/products')->with('status', 'Product added successfully');
    } else {
        // Redirect on failure
        return redirect()->back()->with('error', 'Failed to add product');
    }
    
}


public function productBids()
{
    $db = \Config\Database::connect();
    $builder = $db->table('products')
        ->select('products.*, bids.amount as bid_amount, users.name as seller_name')
        ->join('bids', 'bids.product_id = products.id')
        ->join('sellers', 'products.seller_id = sellers.seller_id')
        ->join('users', 'sellers.user_id = users.id')
        ->where('bids.status', 'approved');

    // Check if there's a search query
    $searchTerm = $this->request->getGet('search');
    if ($searchTerm) {
        $builder->like('products.name', $searchTerm)
                ->orLike('products.description', $searchTerm)
                ->orLike('users.name', $searchTerm);
    }

    $products = $builder->get()->getResult();
    // Example: Check if bidding has ended for each product
    $currentTimestamp = time();
    foreach ($products as $product) {
        $endTime = strtotime($product->end_time);

        if ($currentTimestamp > $endTime) {
            // Bidding has ended for this product
            $product->bidding_status = 'ended';
        } else {
            // Bidding is still open for this product
            $product->bidding_status = 'open';
        }
    }


    return view('seller/product_bids', ['products' => $products]);
}


public function editProduct($id)
{
    $productModel = new ProductModel();
    $categoryModel = new CategoryModel();
    $product = $productModel->find($id);
    $categories = $categoryModel->findAll();
    
    if (!$product) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
    }
    
    return view('seller/edit_product', [
        'product' => $product,
        'categories' => $categories
    ]);
}

// Seller.php (Controller)

public function updateProduct($id)
{
    // Process form submission
    if ($this->request->getMethod() === 'post') {
        $productModel = new ProductModel();

        // Retrieve form inputs
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'minimum_price' => $this->request->getPost('minimum_price'),
            'category_id' => $this->request->getPost('category_id'),
            'end_time' => $this->request->getPost('end_time'), // Assuming you use datetime-local input
        ];

        // Validate and update product
        if ($productModel->update($id, $data)) {
            return redirect()->to('/seller/products')->with('success', 'Product updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update product');
        }
    }

    // Load view for editing product
    $productModel = new ProductModel();
    $categoryModel = new CategoryModel();
    $product = $productModel->find($id);
    $categories = $categoryModel->findAll();

    if (!$product) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
    }

    return view('seller/edit_product', [
        'product' => $product,
        'categories' => $categories,
    ]);
}


public function deleteProduct($id)
{
    $productModel = new ProductModel();
    
    if ($productModel->delete($id)) {
        return redirect()->to('/seller/products')->with('status', 'Product deleted successfully');
    } else {
        return redirect()->back()->with('error', 'Failed to delete product');
    }
}

public function editProfile()
{
    // Fetch seller's details from a method or database query
    $seller = $this->fetchSellerDetails(); // Example method to fetch seller details

    // Pass seller data to the view
    $data = [
        'seller' => $seller,
    ];

    return view('seller/edit_profile', $data);
}



public function updateProfile()
{
    // Handle profile update form submission
    $sellerId = session()->get('seller_id');
    if (!$sellerId) {
        return redirect()->to('seller/login'); // Redirect if seller is not logged in
    }

    // Get form input
    $name = $this->request->getPost('name');
    $email = $this->request->getPost('email');
    $contact = $this->request->getPost('contact');

    // Handle profile image upload if needed
    $profileImage = $this->request->getFile('profile_image');
    if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
        // Generate a unique name for the image
        $newName = $profileImage->getRandomName();

        // Move the file to the upload directory
        $profileImage->move(ROOTPATH . 'public/uploads', $newName);

        // Update profile image path in database
        $profileImagePath = 'uploads/' . $newName;
    } else {
        // Use the existing profile image path if no new image is uploaded
        $profileImagePath = $this->request->getPost('current_profile_image');
    }

    // Example: Update seller profile in database
    $db = \Config\Database::connect();
    $builder = $db->table('sellers');
    $data = [
        'name' => $name,
        'email' => $email,
        'contact' => $contact,
        'profile_image' => $profileImagePath, // Update profile image path
    ];
    $builder->where('seller_id', $sellerId);
    $builder->update($data);

    return redirect()->to('seller/dashboard')->with('success', 'Profile updated successfully');
}

    

private function fetchSellerDetails()
{
    // Example: Fetch seller details from session or database
    $sellerId = session()->get('seller_id');
    if (!$sellerId) {
        return null; // Seller not logged in
    }
    $db = \Config\Database::connect();
    $builder = $db->table('sellers');
    $query = $builder->getWhere(['seller_id' => $sellerId]);

    return $query->getRowArray(); // Return seller details as an array
}

    //

}

