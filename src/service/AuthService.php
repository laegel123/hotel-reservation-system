<?php declare(strict_types=1);

namespace src\service;

use src\repository\UserRepository;

final class AuthService
{
    private UserRepository $userRepository;

    public function __construct(?UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    // register
    public function register(string $name, string $email, string $password, string $role)
    {
        $this->userRepository->insertUser($name, $email, $password, $role);
    }

    // login
    public function login(string $email, string $password)
    {
        $user = $this->userRepository->selectUserByEmailAndPw($email, $password);
        if ($user === null) {
            throw new \Exception('Invalid email or password');
        }
        return $user;
    }
}