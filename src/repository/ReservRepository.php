<?php declare(strict_types=1);

namespace src\repository;

use domain\Reservation;
use util\Database;

final class ReservRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    // select reserv by id
    public function selectReservById($id)
    {
        $sql = 'SELECT * FROM reservation WHERE id = ?';
        return $this->db->fetch($sql, [$id]);
    }

    // select reserv by email
    public function selectReservByEmail($email, $status = null)
    {
        if ($status) {
            $sql = 'SELECT * FROM reservation WHERE user_email = ? AND status = ?';
            return $this->db->fetchAll($sql, [$email, $status]);
        } else {
            $sql = 'SELECT * FROM reservation WHERE user_email = ?';
            return $this->db->fetchAll($sql, [$email]);
        }
    }

    // select reserv by roomID
    public function selectReservByRoomNum($room_num, $status = null)
    {
        if ($status) {
            $sql = 'SELECT * FROM reservation WHERE room_num = ? AND status = ?';
            return $this->db->fetchAll($sql, [$room_num, $status]);
        } else {
            $sql = 'SELECT * FROM reservation WHERE room_id = ?';
            return $this->db->fetchAll($sql, [$room_num]);
        }
    }

    // select reserv by email and roomID
    public function selectReservByEmailAndRoomNumber($email, $room_num, $status = null)
    {
        $sql = 'SELECT * FROM reservation WHERE user_email = ? AND room_num = ? AND status = ?';
        return $this->db->fetch($sql, [$email, $room_num, $status]);
    }

    // insert reservation
    public function insertReserv(Reservation $reservation)
    {
        $sql = 'INSERT INTO reservation (user_email, room_num, status) VALUES (?, ?, ?)';
        $this->db->execute($sql, [
            $reservation->getUserEmail(),
            $reservation->getRoomNum(),
            $reservation->getStatus(),
        ]);
    }

    // update reservation
    public function updateReserv(Reservation $reservation)
    {
        $sql = 'UPDATE reservation SET status = ?, memo = ? WHERE id = ?';
        $this->db->execute($sql, [
            $reservation->getStatus(),
            $reservation->getMemo(),
            $reservation->getID(),
        ]);
    }
}