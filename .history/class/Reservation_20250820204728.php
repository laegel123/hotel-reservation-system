<?php
// Clase Reservation para manejar reservaciones de habitaciones en el hotel
// Cada instancia representa una reservación específica hecha por un usuario
class Reservation {
    // Identificador único de la reservación
    private $reservationId;
    // Identificador del usuario que realiza la reservación
    private $userId;
    // Número de habitación reservada
    private $roomNum;
    // Fecha de check-in
    private $checkInDate;
    // Fecha de check-out
    private $checkOutDate;
    // Estado de la reservación (pending, confirmed, cancelled, etc.)
    private $status;

    /**
     * Constructor de la clase Reservation
     * @param int $reservationId
     * @param int $userId
     * @param int $roomNum
     * @param string $checkInDate
     * @param string $checkOutDate
     * @param string $status
     */
    public function __construct($reservationId, $userId, $roomNum, $checkInDate, $checkOutDate, $status = 'pending') {
        $this->reservationId = $reservationId;
        $this->userId = $userId;
        $this->roomNum = $roomNum;
        $this->checkInDate = $checkInDate;
        $this->checkOutDate = $checkOutDate;
        $this->status = $status;
    }

    // Métodos getter para acceder a los atributos privados
    public function getReservationId() { return $this->reservationId; }
    public function getUserId() { return $this->userId; }
    public function getRoomNum() { return $this->roomNum; }
    public function getCheckInDate() { return $this->checkInDate; }
    public function getCheckOutDate() { return $this->checkOutDate; }
    public function getStatus() { return $this->status; }

    // Métodos setter para modificar atributos específicos
    public function setStatus($status) { $this->status = $status; }
    public function setCheckInDate($date) { $this->checkInDate = $date; }
    public function setCheckOutDate($date) { $this->checkOutDate = $date; }
}

// Clase ReservationManager para gestionar el CRUD de reservaciones
// Permite crear, leer, actualizar y eliminar reservaciones
class ReservationManager {
    // Array que almacena todas las reservaciones
    private $reservations = [];

    /**
     * Constructor de la clase gestora
     * @param array $reservations
     */
    public function __construct($reservations = []) {
        $this->reservations = $reservations;
    }

    /**
     * Crear una nueva reservación y agregarla al array
     * @param int $reservationId
     * @param int $userId
     * @param int $roomNum
     * @param string $checkInDate
     * @param string $checkOutDate
     * @param string $status
     * @return Reservation
     */
    public function addReservation($reservationId, $userId, $roomNum, $checkInDate, $checkOutDate, $status = 'pending') {
        $newReservation = new Reservation($reservationId, $userId, $roomNum, $checkInDate, $checkOutDate, $status);
        $this->reservations[] = $newReservation;
        return $newReservation;
    }

    /**
     * Obtener todas las reservaciones almacenadas
     * @return array
     */
    public function getReservations() {
        return $this->reservations;
    }

    /**
     * Buscar una reservación por su ID
     * @param int $reservationId
     * @return Reservation|null
     */
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
