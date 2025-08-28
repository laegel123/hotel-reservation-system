<?php
// Controller for file upload management
namespace src\controller;

class FileController {
    private $directory = __DIR__ . '/../../uploads/'; // Directory where files are stored

    public function uploadFile() {
        // Check if file was received
        if (!isset($_FILES['file'])) {
            echo json_encode(['error' => 'No file received']);
            return;
        }

        $file = $_FILES['file'];
        $originalName = basename($file['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        // Validate extension
        if (!in_array($extension, $allowed)) {
            echo json_encode(['error' => 'File type not allowed']);
            return;
        }

        // Validate size
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
            echo json_encode(['success' => true, 'file' => $newName]);
        } else {
            echo json_encode(['error' => 'Error saving file']);
        }
    }
}
