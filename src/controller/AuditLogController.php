<?php
namespace src\controller;

require_once __DIR__ . '/../repository/AuditLogRepository.php';
use repository\AuditLogRepository;

class AuditLogController {
    private $repo;

    public function __construct() {
        $this->repo = new AuditLogRepository();
    }

    public function getAllLogs() {
        return $this->repo->getAll();
    }
}
