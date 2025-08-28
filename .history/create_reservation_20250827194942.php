<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/util/Database.php';
util\Database::init(require __DIR__ . '/config/config.php');
require_once __DIR__ . '/src/controller/ResvController.php';
use src\controller\ResvController;

// Adaptar datos POST para el controlador
$data = [
    'user_email' => $_POST['user_email'] ?? '',
    'room_num' => $_POST['room_num'] ?? '',
    'status' => 'pending',
    'memo' => ''
];

class JsonRequest {
    private $data;
    public function __construct($data) { $this->data = $data; }
    public function json($key, $default = '') { return $this->data[$key] ?? $default; }
}
function http_json_input() {
    global $data;
    return new JsonRequest($data);
}

$controller = new ResvController();
ob_start();
$controller->createReserv();
$output = ob_get_clean();
header('Content-Type: application/json');
if (strpos($output, 'success') !== false) {
    echo json_encode(["success" => true, "message" => "Reservación creada correctamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al crear la reservación.", "debug" => $output]);
}
