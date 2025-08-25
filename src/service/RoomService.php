<?php

namespace src\service;

require_once './src/repository/RoomRepository.php';

use src\repository\RoomRepository;
use domain\Room;

final class RoomService
{
    private RoomRepository $roomRepository;

    public function __construct(?RoomRepository $roomRepository = null)
    {
        $this->roomRepository = $roomRepository ?? new RoomRepository();
    }

    // select room by ID
    public function getRoomByNum($room_num)
    {
        return $this->roomRepository->selectRoomByNum($room_num);
    }

    // select all rooms
    public function getRooms()
    {
        return $this->roomRepository->selectRooms();
    }

    // insert room
    public function insertRoom(Room $room)
    {
        $this->roomRepository->insertRoom($room);
    }

    // update room
    public function updateRoom(Room $room)
    {
        $this->roomRepository->updateRoom($room);
    }

    // delete room
    public function deleteRoom($room_num)
    {
        $this->roomRepository->deleteRoom($room_num);
    }

    // update room availability
    public function updateRoomAvailability($room_num, $availableYN)
    {
        $this->roomRepository->updateRoomAvailability($room_num, $availableYN);
    }

}