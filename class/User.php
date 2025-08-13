<?php

class User {
    private $sq;
    private $name;
    private $email;
    private $password;
    private $delYn;
    private $role;

    private $lastLoginDate;
    private $createdDate;

    public function __construct($name, $email, $password, $role) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }


    // Getters
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

    public function getCreatedDate() {
        return $this->createdDate;
    }




    // Setters
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

    public function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;
    }





    // Method to validate password
    public function validatePassword($password) {
        return $this->password === $password;
    }
}
