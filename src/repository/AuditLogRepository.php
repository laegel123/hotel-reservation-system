<?php
namespace repository;

use domain\AuditLog;
use util\Database;

class AuditLogRepository {
    private Database $db;

    public function __construct() {
        $this->db = Database::get();
    }

    // Get all audit records as AuditLog objects from the database
    public function getAll() {
        $sql = 'SELECT * FROM audit_log ORDER BY id DESC';
        $rows = $this->db->fetchAll($sql);
        $records = [];
        foreach ($rows as $row) {
            $records[] = new AuditLog(
                $row['user_email'],
                $row['action'],
                $row['details'],
                $row['timestamp'],
                $row['id']
            );
        }
        return $records;
    }
}
