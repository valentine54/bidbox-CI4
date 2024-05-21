<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

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
    // Get the email from session data
    $email = session()->getFlashdata('email');
    return view('activation_notice', ['email' => $email]);

});
$routes->post('reset-password/update', 'Login::updatePassword');
$routes->get('forgot-password', 'Login::forgotPasswordForm');
$routes->post('forgot-password/send-email', 'Login::sendResetPasswordEmail');
$routes->get('reset-password/(:any)', 'Login::resetPasswordForm/$1');






