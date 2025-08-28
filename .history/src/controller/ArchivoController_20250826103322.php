<?php
// Controlador para la gestión de archivos subidos por los usuarios
namespace src\controller;

class ArchivoController {
    private $directorio = __DIR__ . '/../../uploads/'; // Carpeta donde se guardan los archivos

    public function subirArchivo() {
        if (!isset($_FILES['archivo'])) {
            echo json_encode(['error' => 'No se recibió ningún archivo']);
            return;
        }

        $archivo = $_FILES['archivo'];
        $nombreOriginal = basename($archivo['name']);
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        // Validar extensión
        if (!in_array($extension, $permitidos)) {
            echo json_encode(['error' => 'Tipo de archivo no permitido']);
            return;
        }

        // Validar tamaño
        if ($archivo['size'] > $maxSize) {
            echo json_encode(['error' => 'El archivo es demasiado grande']);
            return;
        }

        // Crear carpeta si no existe
        if (!is_dir($this->directorio)) {
            mkdir($this->directorio, 0777, true);
        }

        // Evitar sobreescritura
        $nuevoNombre = uniqid('file_') . '.' . $extension;
        $rutaDestino = $this->directorio . $nuevoNombre;

        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            echo json_encode(['success' => true, 'archivo' => $nuevoNombre]);
        } else {
            echo json_encode(['error' => 'Error al guardar el archivo']);
        }
    }
}
