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

    public function selectRoomByID($roomID)
    {
        $sql = 'SELECT * FROM room WHERE id = ?';
        return $this->db->fetch($sql, [$roomID]);
    }

    public function selectRooms()
    {
        $sql = 'SELECT * FROM room';
        return $this->db->fetchAll($sql);
    }

    public function insertRoom($room)
    {
        $sql = 'INSERT INTO room (type, roomNum, description, price, capacity, image, available_yn) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $this->db->execute($sql, $room);
    }

    public function updateRoom($room)
    {
        $sql = 'UPDATE room SET type = ?, roomNum = ?, description = ?, price = ?, capacity = ?, image = ?, available_yn = ? WHERE id = ?';
        $this->db->execute($sql, $room);
    }

    public function updateRoomAvailability($roomID, $available_yn)
    {
        $sql = 'UPDATE room SET available_yn = ? WHERE id = ?';
        $this->db->execute($sql, [$available_yn, $roomID]);
    }

    public function deleteRoom($roomID)
    {
        $sql = 'DELETE FROM room WHERE id = ?';
        $this->db->execute($sql, [$roomID]);
    }



}