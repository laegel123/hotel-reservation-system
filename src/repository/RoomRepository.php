<?php declare(strict_types=1);

namespace src\repository;

use util\Database;

final class RoomRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    public function selectRoomByNum($room_num)
    {
        $sql = 'SELECT * FROM room WHERE room_num = ?';
        return $this->db->fetch($sql, [$room_num]);
    }

    public function selectRooms()
    {
        $sql = 'SELECT * FROM room';
        return $this->db->fetchAll($sql);
    }

    public function insertRoom($room)
    {
        $sql = 'INSERT INTO room (room_num, type, description, price, capacity, image, available_yn) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $this->db->execute($sql, [
            $room->getRoomNum(),
            $room->getType(),
            $room->getDescription(),
            $room->getPrice(),
            $room->getCapacity(),
            $room->getImage(),
            $room->getAvailableYn(),
        ]);
    }

    public function updateRoom($room)
    {
        $sql = 'UPDATE room SET type = ?, description = ?, price = ?, capacity = ?, image = ?, available_yn = ? WHERE room_num = ?';
        $this->db->execute($sql, [
            $room->getType(),
            $room->getDescription(),
            $room->getPrice(),
            $room->getCapacity(),
            $room->getImage(),
            $room->getAvailableYn(),
            $room->getRoomNum(),
        ]);
    }

    public function deleteRoom($room_num)
    {
        $sql = 'DELETE FROM room WHERE room_num = ?';
        $this->db->execute($sql, [$room_num]);
    }



}