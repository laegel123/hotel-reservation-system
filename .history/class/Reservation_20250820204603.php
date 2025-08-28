<?php
// Clase Reservation para manejar reservaciones
class Reservation {
    private $reservationId;
    private $userId;
    private $roomNum;
    private $checkInDate;
    private $checkOutDate;
    private $status;

    public function __construct($reservationId, $userId, $roomNum, $checkInDate, $checkOutDate, $status = 'pending') {
        $this->reservationId = $reservationId;
        $this->userId = $userId;
        $this->roomNum = $roomNum;
        $this->checkInDate = $checkInDate;
        $this->checkOutDate = $checkOutDate;
        $this->status = $status;
    }

    // Getters
    public function getReservationId() { return $this->reservationId; }
    public function getUserId() { return $this->userId; }
    public function getRoomNum() { return $this->roomNum; }
    public function getCheckInDate() { return $this->checkInDate; }
    public function getCheckOutDate() { return $this->checkOutDate; }
    public function getStatus() { return $this->status; }

    // Setters
    public function setStatus($status) { $this->status = $status; }
    public function setCheckInDate($date) { $this->checkInDate = $date; }
    public function setCheckOutDate($date) { $this->checkOutDate = $date; }
}

// Clase gestora para el CRUD de reservaciones
class ReservationManager {
    private $reservations = [];

    public function __construct($reservations = []) {
        $this->reservations = $reservations;
    }

    // Crear una nueva reservación
    public function addReservation($reservationId, $userId, $roomNum, $checkInDate, $checkOutDate, $status = 'pending') {
        $newReservation = new Reservation($reservationId, $userId, $roomNum, $checkInDate, $checkOutDate, $status);
        $this->reservations[] = $newReservation;
        return $newReservation;
    }

    // Leer todas las reservaciones
    public function getReservations() {
        return $this->reservations;
    }

    // Buscar reservación por ID
    public function getReservationById($reservationId) {
        foreach ($this->reservations as $reservation) {
            if ($reservation->getReservationId() == $reservationId) {
                return $reservation;
            }
        }
        return null;
    }

    // Actualizar reservación
    public function updateReservation($reservationId, $status = null, $checkInDate = null, $checkOutDate = null) {
        $reservation = $this->getReservationById($reservationId);
        if ($reservation) {
            if ($status !== null) $reservation->setStatus($status);
            if ($checkInDate !== null) $reservation->setCheckInDate($checkInDate);
            if ($checkOutDate !== null) $reservation->setCheckOutDate($checkOutDate);
            return true;
        }
        return false;
    }

    // Eliminar reservación
    public function deleteReservation($reservationId) {
        foreach ($this->reservations as $key => $reservation) {
            if ($reservation->getReservationId() == $reservationId) {
                unset($this->reservations[$key]);
                $this->reservations = array_values($this->reservations);
                return true;
            }
        }
        return false;
    }
}
