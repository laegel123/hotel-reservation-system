<?php

namespace src\service;

require_once './src/repository/ReservRepository.php';

use src\repository\ReservRepository;
use domain\Reservation;

final class ReservService
{
    private ReservRepository $reservRepository;

    public function __construct(?ReservRepository $reservRepository = null)
    {
        $this->reservRepository = $reservRepository ?? new ReservRepository();
    }

    // select reserv by ID
    public function getReservById($id)
    {
        return $this->reservRepository->selectReservById($id);
    }

    // select reserv by email
    public function getReservByEmail($email, $status = null)
    {
        return $this->reservRepository->selectReservByEmail($email, $status);
    }

    // select reserv by roomID
    public function getReservByRoomNum($room_num, $status = null)
    {
        return $this->reservRepository->selectReservByRoomNum($room_num, $status);
    }

    // insert reserv
    public function createReserv(Reservation $reserv)
    {
        $reserv = $this->reservRepository->selectReservByEmailAndRoomNumber($reserv->getUserEmail(), $reserv->getRoomNum(), $reserv->getStatus());

        if ( $reserv != null) {
            throw new \Exception('Reservation already exists');
        }

        $this->reservRepository->insertReserv($reserv);
    }

    // update reserv
    public function updateReserv(Reservation $reserv)
    {
        $this->reservRepository->updateReserv($reserv);
    }

}