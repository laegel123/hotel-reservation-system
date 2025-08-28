<?php

// Controlador para la gestión de archivos subidos por los usuarios
namespace src\controller;

class FileController {
    private $directory = __DIR__ . '/../../uploads/'; // Carpeta donde se guardan los archivos

    public function uploadFile() {
        // Validar si se recibió el archivo
        if (!isset($_FILES['file'])) {
            echo json_encode(['error' => 'No se recibió ningún archivo']);
            return;
        }

        $file = $_FILES['file'];
        $originalName = basename($file['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        // Validar extensión
        if (!in_array($extension, $allowed)) {
            echo json_encode(['error' => 'Tipo de archivo no permitido']);
            return;
        }

        // Validar tamaño
        if ($file['size'] > $maxSize) {
            echo json_encode(['error' => 'El archivo es demasiado grande']);
            return;
        }

        // Crear carpeta si no existe
        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0777, true);
        }

        // Evitar sobreescritura
        $newName = uniqid('file_') . '.' . $extension;
        $destination = $this->directory . $newName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            echo json_encode(['success' => true, 'file' => $newName]);
        } else {
            echo json_encode(['error' => 'Error al guardar el archivo']);
        }
    }
}
