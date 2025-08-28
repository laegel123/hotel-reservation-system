<?php

// controller

require_once __DIR__ . '/src/controller/AuthController.php';
require_once __DIR__ . '/src/controller/UserController.php';
require_once __DIR__ . '/src/controller/RoomController.php';
require_once __DIR__ . '/src/controller/ResvController.php';
require_once __DIR__ . '/src/controller/FileController.php'; //subir archivos 
require_once __DIR__ . '/http/Http.php';
require_once __DIR__ . '/util/Database.php';


use http\HttpResponse;
use src\controller\ResvController;
use util\Database;
use src\controller\AuthController;
use src\controller\UserController;
use src\controller\RoomController;
use src\controller\FileController; 

// database init
$config = require __DIR__ . '/config/config.php';
Database::init($config);

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$authController = new AuthController();
$userController = new UserController();
$roomController = new RoomController();
$resvController = new ResvController();
$fileController = new FileController();


// GET
if ($method === 'GET') {
    switch ($path) {
        case '/':
            break;
        // room
        case '/room/list':
            $roomController->getRooms();
            break;
        case '/room/detail':
            $roomController->getRoom();
            break;

        // reservation
        case '/reserv/listByEmail':
            $resvController->getReservByEmail();
            break;
        case '/reserv/listByRoomNumber':
            $resvController->getReservByRoomNum();
            break;


    }
}

// POST
if ($method === 'POST') {
    switch ($path) {
        // auth
        case '/auth/login':
            $authController->login();
            break;
        case '/auth/logout':
            $authController->logout();
            break;

        // user
        case '/user/register':
            $userController->registerUser();
            break;
        case '/user/delete':
            $userController->deleteUser();
            break;

        // room
        case '/room/create':
            $roomController->createRoom();
            break;
        case '/room/update':
            $roomController->updateRoom();
            break;
        case '/room/delete':
            $roomController->deleteRoom();
            break;

        // reservation
        case '/reserv/create':
            $resvController->createReserv();
            break;
        case '/reserv/update':
            $resvController->updateReserv();
            break;
        case '/reserv/cancel':
            $resvController->cancelReserv();
            break;


        // file upload
        case '/file/upload':
            $fileController->uploadFile();
            break;

        default:
            (new HttpResponse())->json(404, ["success" => false, "error" => "Not Found"]);
    }
}
