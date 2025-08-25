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

    public function selectUserByEmail(string $email)
    {
        $sql = 'SELECT email, password, name, role FROM user WHERE email = ? LIMIT 1';
        $user = $this->db->fetch($sql, [$email]);

        // no user
        if (!$user) {
            return null;
        }

        return $user;
    }

    public function insertUser(string $email, string $pw, string $name, string $role)
    {
        $sql  = 'INSERT INTO user (email, password, name, role) VALUES (?, ?, ?, ?)';
        return $this->db->execute($sql, [$email, $pw, $name, $role]);
    }

    public function deleteUser(string $email)
    {
        $sql = 'DELETE FROM user WHERE email = ?';
        return $this->db->execute($sql, [$email]);
    }
}