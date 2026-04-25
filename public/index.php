<?php
// Front controller — all requests enter here
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
define('DB_PATH', BASE_PATH . '/database/peche_marine.db');
define('UPLOAD_PATH', BASE_PATH . '/public/assets/images/products');

require_once BASE_PATH . '/router.php';
