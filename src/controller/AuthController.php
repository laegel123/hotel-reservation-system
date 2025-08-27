<?php

namespace src\controller;
require_once './http/Http.php';
require_once './src/service/AuthService.php';

use http\HttpRequest;
use http\HttpResponse;
use src\service\AuthService;
use function http\json_input;

final class AuthController
{
    private AuthService $authService;

    public function __construct(?AuthService $authService = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->authService = $authService ?? new AuthService();
    }


    // login
    function login(): void
    {
        $req = json_input();
        $res = new HttpResponse();

        $email = $req->json('email', '');
        $password = $req->json('password', '');

        if ($email == '' || $password == '') {
            $res->json(400, ["success" => false, "error" => "Email and Password are required."]);
        }

        // check login with db
        $user = $this->authService->login($email, $password);
        if ($user === null) {
            $res->json(401, ["success" => false, "error" => "Invalid email or password."]);
        } else {
            $_SESSION['user'] = [
                'email' => $user['email'],
                'role' => $user['role'],
            ];
            $res->json(200, ["success" => true, "user" => $user['email']]);
        }
    }

    // logout
    function logout(): void
    {
        $res = new HttpResponse();
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        $res->json(200, ["success" => true]);
    }

}


