<?php
function generateAuditRecord($userID, $action, $details) {
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] UserID: $userID, Action: $action, Details: $details\n";
    $logFile = 'audit_log.txt';
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}
// Usage example:
// generateAuditRecord(123, 'Login', 'User logged in successfully.');
