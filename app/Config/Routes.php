<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Default route redirects to admin (AuthController akan handle login/dashboard logic)
$routes->get('/', function() {
    return redirect()->to('/admin');
});

// Public Form Routes (untuk QR scan)
$routes->get('/welcome', 'FormController::index');
$routes->match(['GET', 'POST'], '/form/feedback', 'FormController::feedback');
$routes->match(['GET', 'POST'], '/form/guest-book', 'FormController::guestBook');
$routes->get('/thank-you', 'FormController::thankYou');

// Public Guest Book Status Routes
$routes->get('/search-guest-book', 'FormController::searchGuestBook');
$routes->get('/guest-book/detail-balasan/(:num)', 'FormController::detailBalasan/$1');

// Admin Authentication Routes
$routes->get('/admin', 'Admin\AuthController::index'); // Handle auto-redirect based on login status
$routes->match(['GET', 'POST'], '/admin/login', 'Admin\AuthController::login');
$routes->get('/admin/logout', 'Admin\AuthController::logout');

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'adminauth'], function($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');
    $routes->get('dashboard/chart-data', 'Admin\DashboardController::getChartData');
    $routes->get('dashboard/chart-data-realtime', 'Admin\DashboardController::getChartDataRealtime');
    $routes->get('dashboard/export-excel', 'Admin\DashboardController::exportExcel');
    $routes->get('dashboard/export-pdf', 'Admin\DashboardController::exportPdf');
    
    // Keperluan Management
    $routes->get('keperluan', 'Admin\KeperluanController::index');
    $routes->match(['get', 'post'], 'keperluan/create', 'Admin\KeperluanController::create');
    $routes->match(['get', 'post'], 'keperluan/edit/(:num)', 'Admin\KeperluanController::edit/$1');
    $routes->get('keperluan/delete/(:num)', 'Admin\KeperluanController::delete/$1');
    
    // Form Builder
    $routes->get('form-builder', 'Admin\FormBuilderController::index');
    $routes->match(['get', 'post'], 'form-builder/create', 'Admin\FormBuilderController::create');
    $routes->match(['get', 'post'], 'form-builder/edit/(:num)', 'Admin\FormBuilderController::edit/$1');
    $routes->get('form-builder/delete/(:num)', 'Admin\FormBuilderController::delete/$1');
    $routes->post('form-builder/update-order', 'Admin\FormBuilderController::updateOrder');
    
    // QR Code Management
    $routes->get('generate-qr', 'Admin\QrController::index');
    $routes->post('generate-qr/generate', 'Admin\QrController::generate');
    $routes->get('generate-qr/print', 'Admin\QrController::print');
    $routes->get('generate-qr/download-pdf', 'Admin\QrController::downloadPdf');
    
    // Feedback Management
    $routes->get('feedback', 'Admin\FeedbackController::index');
    $routes->get('feedback/view/(:num)', 'Admin\FeedbackController::view/$1');
    $routes->get('feedback/delete/(:num)', 'Admin\FeedbackController::delete/$1');
    
    // Guest Book Management
    $routes->get('guest-book', 'Admin\GuestBookController::index');
    $routes->get('guest-book/balas', 'Admin\GuestBookController::balas');
    $routes->get('guest-book/view/(:num)', 'Admin\GuestBookController::view/$1');
    $routes->get('guest-book/reply/(:num)', 'Admin\GuestBookController::reply/$1');
    $routes->post('guest-book/save-reply/(:num)', 'Admin\GuestBookController::saveReply/$1');
    $routes->get('guest-book/delete-reply/(:num)', 'Admin\GuestBookController::deleteReply/$1');
    $routes->get('guest-book/delete/(:num)', 'Admin\GuestBookController::delete/$1');
    $routes->get('guest-book/export-pdf', 'Admin\GuestBookController::exportPdf');
    $routes->get('guest-book/export-excel', 'Admin\GuestBookController::exportExcel');
    
    // File Download
    $routes->get('download-file/(:any)', 'Admin\FileController::download/$1');
    
    // Visitor History
    $routes->get('riwayat', 'Admin\RiwayatController::index');
});

// QR Code Image Route
$routes->get('qr/(:any)', 'Admin\QrController::qrImage/$1');