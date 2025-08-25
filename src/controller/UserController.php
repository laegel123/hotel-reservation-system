<?php
namespace src\controller;

require_once './http/Http.php';
require_once './src/service/UserService.php';

use http\HttpRequest;
use http\HttpResponse;
use src\service\UserService;

final class UserController
{

    private UserService $userService;

    public function __construct(?UserService $userService = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->userService = $userService ?? new UserService();
    }

    private function json_input(): HttpRequest
    {
        return new HttpRequest(file_get_contents('php://input'));
    }

    function registerUser(): void
    {
        $req = $this->json_input();
        $res = new HttpResponse();

        $name = $req->json('name', '');
        $email = $req->json('email', '');
        $password = $req->json('password', '');
        $role = $req->json('role', '');

        if ($name == '' || $email == '' || $password == '' || $role == '') {
            $res->json(400, ["success" => false, "error" => "Name and Email and Password, Role are required."]);
        }

        $this->userService->register($email, $password, $name, $role);
        $res->json(200, ["success" => true]);
    }

    function deleteUser(): void
    {
        $req = $this->json_input();
        $res = new HttpResponse();

        $email = $req->json('email', '');
        if ($email == '') {
            $res->json(400, ["success" => false, "error" => "Email is required."]);
        }

        if ($_SESSION['user']['role'] != 'admin') {
            $res->json(403, ["success" => false, "error" => "You are not admin."]);
        }

        $this->userService->deleteUser($email);
        $res->json(200, ["success" => true]);
    }

}