<?php
require_once __DIR__ . '/src/repository/RoomRepository.php';
use src\repository\RoomRepository;

$repo = new RoomRepository();
$rooms = $repo->selectRooms();
header('Content-Type: application/json');
echo json_encode($rooms);
