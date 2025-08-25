<?php

namespace src\controller;

require_once './http/Http.php';
require_once './src/service/RoomService.php';

use http\HttpRequest;
use http\HttpResponse;
use src\service\RoomService;

class RoomController
{
    private RoomService $roomService;

    public function __construct(?RoomService $roomService = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function json_input(): HttpRequest
    {
        return new HttpRequest(file_get_contents('php://input'));
    }

    // get rooms
    public function getRooms()
    {
        $res = new HttpResponse();
        $rooms = $this->roomService->getRooms();
        $res->json(200, $rooms);
    }

    public function createRoom()
    {
        // post file
        $res = new HttpResponse();
        try {
            $type = $_POST['type'];
            $roomNum = $_POST['roomNum'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $capacity = $_POST['capacity'];
            $available_yn = $_POST['available_yn'];

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image'];
            }

            $uploadDir = __DIR__ . '/../../uploads/rooms';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $imagePath = $uploadDir . '/' . basename($file['name']);

            move_uploaded_file($file['tmp_name'], $imagePath);

            $room = [
                $type,
                $roomNum,
                $description,
                $price,
                $capacity,
                $imagePath,      // may be null if no file uploaded
                $available_yn,
            ];

            $this->roomService->insertRoom($room);

            $res->json(200, [
                'message' => 'Room created successfully',
                'room' => [
                    'type' => $type,
                    'roomNum' => $roomNum,
                    'description' => $description,
                    'price' => $price,
                    'capacity' => $capacity,
                    'image' => $imagePath,
                    'available_yn' => $available_yn,
                ],
            ]);


        } catch (\Throwable $e) {
            $res->json(500, ['error' => 'Internal Server Error', 'details' => $e->getMessage()]);
        }
    }


}