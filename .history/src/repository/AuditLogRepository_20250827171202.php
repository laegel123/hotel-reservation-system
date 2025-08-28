<?php
// Repository for reading audit log records from the file
// Repositorio para leer los registros de auditoría

namespace repository;

use domain\AuditLog;

class AuditLogRepository {
    private $logFile;

    public function __construct($logFile = 'audit_log.txt') {
        $this->logFile = $logFile;
    }

    // Get all audit records as AuditLog objects
    public function getAll() {
        $records = [];
        if (!file_exists($this->logFile)) {
            return $records;
        }
        $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Example line: [2025-08-27 15:30:00] UserID: admin@example.com, Action: update_status, Details: Status changed from pending to confirmed
            if (preg_match('/\[(.*?)\] UserID: (.*?), Action: (.*?), Details: (.*)/', $line, $matches)) {
                $records[] = new AuditLog(
                    $matches[2], // user_email
                    $matches[3], // action
                    $matches[4], // details
                    $matches[1]  // timestamp
                );
            }
        }
        return $records;
    }
}
