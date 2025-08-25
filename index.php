<?php

// controller
require_once __DIR__ . '/src/controller/AuthController.php';
require_once __DIR__ . '/src/controller/UserController.php';
require_once __DIR__ . '/src/controller/RoomController.php';
require_once __DIR__ . '/http/Http.php';
require_once __DIR__ . '/util/Database.php';

use http\HttpResponse;
use util\Database;
use src\controller\AuthController;
use src\controller\UserController;
use src\controller\RoomController;

// database init
$config = require __DIR__ . '/config/config.php';
Database::init($config);

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$authController = new AuthController();
$userController = new UserController();
$roomController = new RoomController();

// POST
if ($method === 'POST') {
    switch ($path) {
        case '/auth/login':
            $authController->login();
            break;
        case '/auth/logout':
            $authController->logout();
            break;
        case '/user/register':
            $userController->registerUser();
            break;
        case '/user/delete':
            $userController->deleteUser();
            break;
        case '/create/room':
            $roomController->createRoom();
        default:
            (new HttpResponse())->json(404, ["success" => false, "error" => "Not Found"]);
    }
}
