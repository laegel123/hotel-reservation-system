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
function http\json_input() {
    global $data;
    return new JsonRequest($data);
}

$controller = new ResvController();
ob_start();
$controller->createReserv();
$output = ob_get_clean();
echo '<div style="font-family:Arial;max-width:500px;margin:40px auto;padding:30px;background:#f7f7f7;border-radius:10px;">';
if (strpos($output, 'success') !== false) {
    echo '<h2>Reservación creada correctamente.</h2>';
} else {
    echo '<h2>Error al crear la reservación.</h2>';
    echo '<pre>' . htmlspecialchars($output) . '</pre>';
}
echo '<a href="hotel_reservation.php">Volver</a>';
echo '</div>';
