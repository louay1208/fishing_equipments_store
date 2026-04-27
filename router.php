<?php
require_once BASE_PATH . '/config/config.php';
require_once APP_PATH . '/models/Database.php';

// Initialize database
Database::init();

// Get request info
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

// Load controllers
require_once APP_PATH . '/controllers/HomeController.php';
require_once APP_PATH . '/controllers/AuthController.php';
require_once APP_PATH . '/controllers/ProductController.php';
require_once APP_PATH . '/controllers/CartController.php';
require_once APP_PATH . '/controllers/OrderController.php';
require_once APP_PATH . '/controllers/ProfileController.php';
require_once APP_PATH . '/controllers/ContactController.php';
require_once APP_PATH . '/controllers/AdminController.php';

// Simple router
match(true) {
    // Home
    $uri === '/' && $method === 'GET'
        => HomeController::index(),

    // Auth
    $uri === '/login' && $method === 'GET'
        => AuthController::loginForm(),
    $uri === '/login' && $method === 'POST'
        => AuthController::login(),
    $uri === '/register' && $method === 'GET'
        => AuthController::registerForm(),
    $uri === '/register' && $method === 'POST'
        => AuthController::register(),
    $uri === '/logout' && $method === 'GET'
        => AuthController::logout(),

    // Products
    $uri === '/products' && $method === 'GET'
        => ProductController::index(),
    preg_match('#^/products/(\d+)$#', $uri, $m) && $method === 'GET'
        => ProductController::show((int)$m[1]),

    // Cart
    $uri === '/cart' && $method === 'GET'
        => CartController::index(),
    $uri === '/cart/add' && $method === 'POST'
        => CartController::add(),
    $uri === '/cart/update' && $method === 'POST'
        => CartController::update(),
    $uri === '/cart/remove' && $method === 'POST'
        => CartController::remove(),

    // Orders
    $uri === '/checkout' && $method === 'GET'
        => OrderController::checkout(),
    $uri === '/orders' && $method === 'POST'
        => OrderController::store(),
    $uri === '/orders' && $method === 'GET'
        => OrderController::history(),
    preg_match('#^/orders/(\d+)$#', $uri, $m) && $method === 'GET'
        => OrderController::show((int)$m[1]),

    // Profile
    $uri === '/profile' && $method === 'GET'
        => ProfileController::index(),
    $uri === '/profile' && $method === 'POST'
        => ProfileController::update(),

    // Contact
    $uri === '/contact' && $method === 'GET'
        => ContactController::index(),
    $uri === '/contact' && $method === 'POST'
        => ContactController::store(),

    // Admin
    $uri === '/admin' && $method === 'GET'
        => AdminController::dashboard(),
    $uri === '/admin/products' && $method === 'GET'
        => AdminController::products(),
    $uri === '/admin/products/store' && $method === 'POST'
        => AdminController::storeProduct(),
    $uri === '/admin/products/update' && $method === 'POST'
        => AdminController::updateProduct(),
    $uri === '/admin/products/delete' && $method === 'POST'
        => AdminController::deleteProduct(),
    $uri === '/admin/categories' && $method === 'GET'
        => AdminController::categories(),
    $uri === '/admin/categories/store' && $method === 'POST'
        => AdminController::storeCategory(),
    $uri === '/admin/categories/delete' && $method === 'POST'
        => AdminController::deleteCategory(),
    $uri === '/admin/orders' && $method === 'GET'
        => AdminController::orders(),
    $uri === '/admin/orders/status' && $method === 'POST'
        => AdminController::updateStatus(),

    // 404
    default => (function() {
        http_response_code(404);
        $pageTitle = 'Page introuvable — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/404.php';
        require VIEW_PATH . '/layouts/footer.php';
    })(),
};
