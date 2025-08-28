<?php
// Controller for audit log actions
// Controlador para mostrar registros de auditoría

namespace src\controller;

require_once __DIR__ . '/../repository/AuditLogRepository.php';
require_once __DIR__ . '/../domain/AuditLog.php';

use repository\AuditLogRepository;

class AuditLogController {
    private $repo;

    public function __construct() {
        $this->repo = new AuditLogRepository();
    }

    // Example method to get all audit logs
    public function getAllLogs() {
        return $this->repo->getAll();
    }
}
