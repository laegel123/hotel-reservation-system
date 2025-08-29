<?php

namespace src\service;

require_once './src/repository/UserRepository.php';
use src\repository\UserRepository;

final class UserService
{
    private UserRepository $userRepository;

    public function __construct(?UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    // register
    public function register(string $email, string $password, string $name, string $role)
    {
        $user = $this->userRepository->selectUserByEmail($email);
        if ($user !== null) {
            throw new \Exception('User already exists');
        }

        // password hash
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->userRepository->insertUser($email, $password, $name, $role);
    }

    // delete
    public function deleteUser(string $email)
    {
        $this->userRepository->deleteUser($email);
    }
}