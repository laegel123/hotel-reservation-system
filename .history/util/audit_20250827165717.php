
<?php

function insertAuditRecord($userEmail, $action, $details) { //define la funcion para guardar los records 

    $host = 'localhost';
    $db   = 'hospital_db';
    $user = 'root';
    $pass = '';
    //Define los datos de conexion en la base de datos (sql)
    $mysqli = new mysqli($host, $user, $pass, $db); //base de datos local por eso uso host 
    $stmt = $mysqli->prepare('INSERT INTO audit_log (user_email, action, details) VALUES (?, ?, ?)');
    if ($stmt) {
        $stmt->bind_param('sss', $userEmail, $action, $details);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
}


