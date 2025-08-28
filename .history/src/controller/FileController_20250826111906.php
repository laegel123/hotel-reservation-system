<?php
namespace src\controller;

class FileController {
    private $directory = __DIR__ . '/../../uploads/';

    public function uploadFile() {
        if (!isset($_FILES['file'])) {
            echo "No file received";
            return;
        }

        $file = $_FILES['file'];
        if (!is_dir($this->directory)) {
            mkdir($this->directory);
        }
        $destination = $this->directory . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            echo "File uploaded successfully";
        } else {
            echo "Error saving file";
        }
    }
}
