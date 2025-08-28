
<?php

function insertAuditRecord($userEmail, $action, $details) {
    // Guarda el registro de auditoría en la base de datos
    $host = 'localhost';
    $db   = 'hospital_db';
    $user = 'root';
    $pass = '';
    $mysqli = new mysqli($host, $user, $pass, $db);
    $stmt = $mysqli->prepare('INSERT INTO audit_log (user_email, action, details) VALUES (?, ?, ?)');
    if ($stmt) {
        $stmt->bind_param('sss', $userEmail, $action, $details);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
}


