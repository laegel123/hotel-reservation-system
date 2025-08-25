<?php

namespace src\service;

require_once './src/repository/RoomRepository.php';

use src\repository\RoomRepository;

class RoomService
{
    private RoomRepository $roomRepository;

    public function __construct(?RoomRepository $roomRepository = null)
    {
        $this->roomRepository = $roomRepository ?? new RoomRepository();
    }

    // select room by ID
    public function getRoom($roomID)
    {
        return $this->roomRepository->selectRoomByID($roomID);
    }

    // select all rooms
    public function getRooms()
    {
        return $this->roomRepository->selectRooms();
    }

    // insert room
    public function insertRoom($room)
    {
        return $this->roomRepository->insertRoom($room);
    }

    // update room
    public function updateRoom($room)
    {
        return $this->roomRepository->updateRoom($room);
    }

    // delete room
    public function deleteRoom($roomID)
    {
        return $this->roomRepository->deleteRoom($roomID);
    }

    // update room availability
    public function updateRoomAvailability($roomID, $availableYN)
    {
        return $this->roomRepository->updateRoomAvailability($roomID, $availableYN);
    }

}