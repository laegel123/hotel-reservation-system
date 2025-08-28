<?php
require_once __DIR__ . '/src/controller/AuditLogController.php';
use src\controller\AuditLogController;

$controller = new AuditLogController();
$logs = $controller->getAllLogs();
header('Content-Type: application/json');
echo json_encode($logs);
