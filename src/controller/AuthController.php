<?php

namespace src\controller;
require_once '../http/Http.php';

use http\HttpRequest;
use http\HttpResponse;
use src\service\AuthService;

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

    private function json_input(): HttpRequest
    {
        return new HttpRequest(file_get_contents('php://input'));
    }


    // login
    function login(): void
    {
        $req = $this->json_input();
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
            $res->json(200, ["success" => true, "user" => $user]);
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


