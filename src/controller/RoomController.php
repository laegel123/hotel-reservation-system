<?php

namespace src\controller;

require_once './http/Http.php';
require_once './src/service/RoomService.php';
require_once './domain/Room.php';

use http\HttpRequest;
use http\HttpResponse;
use src\service\RoomService;
use domain\Room;
use function http\json_input;

final class RoomController
{
    private RoomService $roomService;

    public function __construct(?RoomService $roomService = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->roomService = $roomService ?? new RoomService();
    }

    // get rooms
    public function getRooms()
    {
        $res = new HttpResponse();
        $rooms = $this->roomService->getRooms();
        $res->json(200, $rooms);
    }

    public function getRoom()
    {
        $res = new HttpResponse();
        $req = json_input();

        $id = $req->json('room_num', '');

        $rooms = $this->roomService->getRoomByNum($id);
        $res->json(200, $rooms);
    }

    // create room
    public function createRoom()
    {
        $res = new HttpResponse();

        if ($_SESSION['user'] == null || $_SESSION['user']['role'] != 'admin') {
            $res->json(403, ["success" => false, "error" => "You are not admin."]);
            return;
        }

        try {

            $room = new Room(
                $_POST['room_num'],
                $_POST['type'],
                $_POST['description'],
                $_POST['capacity'],
                $_POST['price'],
                null,
                $_POST['available_yn']
            );

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image'];
            } else {
                $res->json(400, ['error' => 'No file uploaded']);
                return;
            }

            $uploadDir = __DIR__ . '/../../uploads/rooms';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $imagePath = $uploadDir . '/' . basename($file['name']);

            move_uploaded_file($file['tmp_name'], $imagePath);

            $room->setImage($imagePath);
            $this->roomService->insertRoom($room);

            $res->json(200, [
                'message' => 'Room created successfully'
            ]);


        } catch (\Throwable $e) {
            $res->json(500, ['error' => 'Internal Server Error', 'details' => $e->getMessage()]);
        }
    }

    // update room
    public function updateRoom()
    {
        $res = new HttpResponse();

        if ($_SESSION['user'] == null || $_SESSION['user']['role'] != 'admin') {
            $res->json(403, ["success" => false, "error" => "You are not admin."]);
            return;
        }

        try {
            $room = new Room(
                $_POST['room_num'],
                $_POST['type'],
                $_POST['description'],
                $_POST['capacity'],
                $_POST['price'],
                $_POST['image'] ?? null,
                $_POST['available_yn']
            );

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

            $room->setImage($imagePath);

            $this->roomService->updateRoom($room);

            $res->json(200, [
                'message' => 'Room modified successfully'
            ]);


        } catch (\Throwable $e) {
            $res->json(500, ['error' => 'Internal Server Error', 'details' => $e->getMessage()]);
        }
    }

    // delete room
    public function deleteRoom()
    {
        $res = new HttpResponse();
        $req = json_input();

        $room_num = $req->json('room_num', '');
        if ($room_num == '') {
            $res->json(400, ["success" => false, "error" => "Room Number is required."]);
            return;
        }

        if ($_SESSION['user'] == null || $_SESSION['user']['role'] != 'admin') {
            $res->json(403, ["success" => false, "error" => "You are not admin."]);
            return;
        }

        $this->roomService->deleteRoom($room_num);
        $res->json(200, ["success" => true]);
    }



}