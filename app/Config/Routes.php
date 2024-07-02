<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('hello', 'Hello::index');
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('dashboard', 'HomePage::index');
$routes->post('dashboard/unlock', 'HomePage::unlock');
$routes->get('/dashboard/logout', 'HomePage::logout');
$routes->get('activate/(:any)', 'Register::activate/$1');
$routes->get('register', 'Register::index');
$routes->post('register/process', 'Register::process');
$routes->get('register/success', 'Register::success');
$routes->get('register/activate/(:segment)', 'Register::activate/$1');
$routes->get('activation_notice', function() {
    // Get the email from session data
    $email = session()->getFlashdata('email');
    return view('activation_notice', ['email' => $email]);

});
$routes->post('reset-password/update', 'Login::updatePassword');
$routes->get('forgot-password', 'Login::forgotPasswordForm');
$routes->post('forgot-password/send-email', 'Login::sendResetPasswordEmail');
$routes->get('reset-password/(:any)', 'Login::resetPasswordForm/$1');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('users', 'AdminController::users');
    $routes->get('users/(:segment)', 'AdminController::users/$1');
    $routes->get('edit-user/(:num)', 'AdminController::editUser/$1');
    $routes->post('update-user/(:num)', 'AdminController::updateUser/$1');
    $routes->get('delete-user/(:num)', 'AdminController::deleteUser/$1');
    $routes->get('roles', 'AdminController::roles');
    $routes->get('sales-history', 'AdminController::salesHistory');
    $routes->post('update-role/(:num)', 'AdminController::updateRole/$1');
    $routes->get('applications', 'AdminController::index');
    $routes->post('disapprove', 'AdminController::disapprove');
    $routes->post('update-status', 'AdminController::updateStatus');


    $routes->post('update_status_direct', 'AdminController::update_status_direct');






});
$routes->group('auctioneer', ['namespace' => 'App\Controllers\Auctioneer'], function($routes) {
    $routes->get('view-sellers', 'AuctioneerController::viewSellers');
    $routes->get('view-bidders', 'AuctioneerController::viewBidders');
    $routes->get('view-bids', 'AuctioneerController::viewBids');
    $routes->get('manage-bids', 'AuctioneerController::manageBids');
    $routes->get('update-bid-status/(:num)/(:alpha)', 'AuctioneerController::updateBidStatus/$1/$2');
});
$routes->get('/', 'HomeController::index');
$routes->get('home/index/(:num)', 'HomeController::index/$1');
$routes->get('home/index/all', 'HomeController::index/all');

$routes->get('profile/edit', 'ProfileController::edit');
$routes->post('profile/update', 'ProfileController::update');


$routes->get('merchant-application', 'ApplicationController::merchant');
$routes->get('auctioneer-application', 'ApplicationController::auctioneer');
$routes->post('application/submit', 'ApplicationController::submit');
$routes->get('admin/applications', 'AdminController::index');
$routes->get('admin/updateStatus/(:num)/(:alpha)', 'AdminController::updateStatus/$1/$2');











