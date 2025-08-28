
<?php
// audit.php - Simple audit log function for database
// Guarda registros de auditoría en la tabla audit_log

function insertAuditRecord($userEmail, $action, $details) {
    // Cambia los datos de conexión según tu configuración
    $host = 'localhost';
    $db   = 'hospital_db';
    $user = 'root';
    $pass = '';
    $mysqli = new mysqli($host, $user, $pass, $db);

    if ($mysqli->connect_error) {
        // Error de conexión
        return false;
    }

    $stmt = $mysqli->prepare(
        'INSERT INTO audit_log (user_email, action, details) VALUES (?, ?, ?)'
    );
    if (!$stmt) {
        // Error preparando la consulta
        $mysqli->close();
        return false;
    }
    $stmt->bind_param('sss', $userEmail, $action, $details);
    $result = $stmt->execute();
    $stmt->close();
    $mysqli->close();
    return $result;
}

// Ejemplo de uso:
// insertAuditRecord('user@example.com', 'update', 'Changed room price');
