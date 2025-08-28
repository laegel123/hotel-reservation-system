<?php
require_once __DIR__ . '/src/controller/ResvController.php';
use src\controller\ResvController;

// Simular datos POST como JSON
$data = [
    'user_email' => $_POST['user_email'] ?? '',
    'room_num' => $_POST['room_num'] ?? '',
    'status' => 'pending',
    'memo' => ''
];

// Convertir a objeto para el controlador
class JsonRequest {
    private $data;
    public function __construct($data) { $this->data = $data; }
    public function json($key, $default = '') { return $this->data[$key] ?? $default; }
}
function http_json_input() {
    global $data;
    return new JsonRequest($data);
}

// Ejecutar el controlador
$controller = new ResvController();
$controller->createReserv();
