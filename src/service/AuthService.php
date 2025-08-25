<?php declare(strict_types=1);

namespace src\service;

require_once './src/repository/UserRepository.php';

use src\repository\UserRepository;

final class AuthService
{
    private UserRepository $userRepository;

    public function __construct(?UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    // login
    public function login(string $email, string $password)
    {
        $user = $this->userRepository->selectUserByEmail($email);
        if ($user === null) {
            throw new \Exception('Invalid email or password');
        }

        // password mismatch
        if (!password_verify($password, $user['password'])) {
            throw new \Exception('Invalid email or password');
        }

        $this->userRepository->updateLoginDate($email);
        return $user;
    }
}