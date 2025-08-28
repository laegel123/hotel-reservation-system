<?php
// Domain class for audit log records

namespace domain;

class AuditLog {
    public $id;
    public $user_email;
    public $action;
    public $details;
    public $timestamp;

    public function __construct($user_email, $action, $details, $timestamp = null, $id = null) {
        $this->id = $id;
        $this->user_email = $user_email;
        $this->action = $action;
        $this->details = $details;
        $this->timestamp = $timestamp;
    }
}
