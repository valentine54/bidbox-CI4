<?php

use CodeIgniter\Router\RouteCollection;

use CodeIgniter\Routing\Router;
/**
 * @var RouteCollection $routes
 */

// Basic Routes
$routes->get('/', 'Home::index');
$routes->get('hello', 'Hello::index');
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('dashboard', 'HomePage::index');
$routes->post('dashboard/unlock', 'HomePage::unlock');
$routes->post('/dashboard/logout', 'HomePage::logout');
$routes->get('activate/(:any)', 'Register::activate/$1');
$routes->get('register', 'Register::index');
$routes->post('register/process', 'Register::process');
$routes->get('register/success', 'Register::success');
$routes->get('register/activate/(:segment)', 'Register::activate/$1');
$routes->get('activation_notice', function() {
    $email = session()->getFlashdata('email');
    return view('activation_notice', ['email' => $email]);
});
$routes->post('reset-password/update', 'Login::updatePassword');
$routes->get('forgot-password', 'Login::forgotPasswordForm');
$routes->post('forgot-password/send-email', 'Login::sendResetPasswordEmail');
$routes->get('reset-password/(:any)', 'Login::resetPasswordForm/$1');

$routes->get('mpesa', 'Mpesa::index');
$routes->get('mpesa/access_token', 'Mpesa::access_token');
$routes->get('mpesa/express', 'Mpesa::express');
$routes->get('mpesa/register_urls', 'Mpesa::register_urls');

//seller
//$routes->get('seller', 'Seller::index');
//$routes->get('seller/index', 'Seller::index');

//$routes->get('seller/categories', 'Seller::categories');
//$routes->get('seller/addCategory', 'Seller::addCategory');
//$routes->post('seller/addCategory', 'Seller::addCategory');
//$routes->get('seller/products', 'Seller::products');
//$routes->get('seller/productBids', 'Seller::productBids');


$routes->get('/', 'Home::index');
$routes->get('/seller/index', 'Seller::index');
$routes->get('/seller/categories', 'Seller::categories');
$routes->get('/seller/addCategory', 'Seller::addCategory');
$routes->post('/seller/addcategory', 'Seller::addcategory');
$routes->get('/seller/viewProducts/(:num)', 'Seller::viewProducts/$1');
$routes->get('/seller/products', 'Seller::products');
$routes->get('/seller/productBids', 'Seller::productBids');
$routes->get('/seller/viewProducts/(:num)', 'Seller::viewProducts/$1');
// Example route for addProduct method in Seller controller
$routes->get('seller/products', 'Seller::products');
//$routes->match(['get', 'post'], 'seller/addProduct', 'Seller::addProduct');
$routes->get('seller/addProduct', 'Seller::addProduct');
$routes->post('seller/addProduct', 'Seller::addProduct');

$routes->get('seller/editProduct/(:num)', 'Seller::editProduct/$1');
$routes->post('seller/updateProduct/(:num)', 'Seller::updateProduct/$1');
$routes->get('seller/deleteProduct/(:num)', 'Seller::deleteProduct/$1');
$routes->get('seller/editProfile', 'Seller::editProfile');
$routes->post('seller/updateProfile', 'Seller::updateProfile');



//// Default route for bidder controller
// Default route for bidder controller
// Example: Route to bidder's dashboard or homepage
$routes->get('bidder', 'Bidder::index');  // Adjust as per your actual route structure
$routes->post('bidder/index', 'Bidder::index');

// Route for displaying the bidder's bids
$routes->get('your_bids.php', 'Bidder::yourBids');

// Route for displaying approved bids
$routes->get('approved_bids.php', 'Bidder::approvedBids');

// Route for managing categories

$routes->get('categories', 'Bidder::categories');
$routes->post('categories', 'Bidder::categories');


$routes->get('/cart.php', 'Cart::index');
$routes->post('cart/addItem', 'Cart::addItem');
$routes->post('cart/removeItem', 'Cart::removeItem'); // Create this method in the Cart controller if you want to handle item removal.
$routes->post('categories', 'Bidder::categories');
// Route for adding to cart
$routes->post('addToCart', 'Cart::add');

// Route for placing bids
$routes->post('place_bid', 'Bidder::placeBid');

// Route for updating bidder profile
$routes->post('update_profile', 'Bidder::updateProfile');

// Routes for Delivery
$routes->get('bidder/delivery', 'Delivery::index');
$routes->post('bidder/delivery/process', 'Delivery::process');
$routes->post('bidder/delivery/payment', 'Delivery::payment');


$routes->post('mpesa/initiate-stk-push', 'Mpesa::initiateSTKPush');
$routes->post('mpesa/handle-callback', 'Mpesa::handleMpesaCallback');
$routes->post('mpesa/initiate-stk-push', 'StkController::initiateSTKPush');
// Example route for payment callback handling
$route['payment'] = 'payment/index'; // or 'payment' if you want it to default to index method





// Route for logging out
$routes->get('logout', 'BaseController::logout');

?>