<?php declare(strict_types=1);

namespace src\repository;

use util\Database;

final class UserRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    public function selectUserByEmailAndPw(string $email, string $pw)
    {
        $user = $this->db->fetch('SELECT * FROM user WHERE email = :email', ['email' => $email]);

        // no user
        if (!$user) {
            return null;
        }

        // password mismatch
        if (!password_verify($pw, $user['password'])) {
            return null;
        }

        return $user;
    }

    public function insertUser(string $email, string $pw, string $name, string $role)
    {
        return $this->db->execute('INSERT INTO user (email, password, name, role) VALUES (:email, :pw, :name, :role)', ['email' => $email, 'pw' => $pw, 'name' => $name, 'role' => $role]);
    }
}