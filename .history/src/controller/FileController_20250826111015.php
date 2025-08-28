<?php
namespace src\controller;

class FileController {
    private $directory = __DIR__ . '/../../uploads/'; // directorio donde se guardan los archivos, se crea automaticamente cuando se suben el primer archivo

    public function uploadFile($userId = null, $reservationId = null) {
        // verifica si se recivio el archivo, de no ser asi echo "no file received"
        if (!isset($_FILES['file'])) {
            echo json_encode(['error' => 'No file received']);
            return;
        }

        $file = $_FILES['file'];
        $originalName = basename($file['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        // Valida la extencion, si no es permitida se retorna un error
        if (!in_array($extension, $allowed)) {
            echo json_encode(['error' => 'File type not allowed']);
            return;
        }

        // Validate el tamano y da un error si es muy grand eel archivo 
        if ($file['size'] > $maxSize) {
            echo json_encode(['error' => 'File is too large']);
            return;
        }

        // Create directory if it does not exist
        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0777, true);
        }

        // Prevent overwrite
        $newName = uniqid('file_') . '.' . $extension;
        $destination = $this->directory . $newName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Optionally, relate the file to a user or reservation in the database here
            echo json_encode(['success' => true, 'file' => $newName]);
        } else {
            echo json_encode(['error' => 'Error saving file']);
        }
    }
}
