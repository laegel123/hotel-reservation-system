<?php declare(strict_types=1);

namespace domain;

require_once './domain/Common.php';

use Common;

class User extends Common {
    private $email;
    private $name;
    private $password;
    private $delYn;
    private $role;

    private $lastLoginDate;

    public function __construct($name, $email, $password, $role) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }


    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getLastLoginDate() {
        return $this->lastLoginDate;
    }

    public function getRole() {
        return $this->role;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setLastLoginDate($lastLoginDate) {
        $this->lastLoginDate = $lastLoginDate;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getDelYn()
    {
        return $this->delYn;
    }

    public function setDelYn($delYn): void
    {
        $this->delYn = $delYn;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

}
