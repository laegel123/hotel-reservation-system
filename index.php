<?php

// controller
require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/http/Http.php';

use http\HttpResponse;
use util\Database;

// database init
$config = require __DIR__ . '/../config.php';
Database::init($config);

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);



// POST
if ($method === 'POST') {
    if ($path === '/auth/login') {
        login();
    } else if ($path === '/auth/logout') {
        logout();
    }
}
