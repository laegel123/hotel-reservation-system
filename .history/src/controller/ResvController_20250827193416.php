<?php

namespace src\controller;

require_once './http/Http.php';
require_once './src/service/ReservService.php';
require_once './domain/Reservation.php';

use http\HttpRequest;
use http\HttpResponse;
use src\service\ReservService;
use domain\Reservation;
use function http\json_input;

final class ResvController
{
    private ReservService $reservService;

    public function __construct(?ReservService $reservService = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->reservService = $reservService ?? new ReservService();
    }

    // get reserv by email
    public function getReservByEmail()
    {
        $req = json_input();
        $res = new HttpResponse();

        if ($_SESSION['user'] == null) {
            $res->json(401, ["success" => false, "error" => "You are not logged in."]);
            return;
        }

        $email = $_GET['email'] ?? '';
        $status = $_GET['status'] ?? '';

        if ($_SESSION['user']['role'] != 'admin' && $_SESSION['user']['email'] != $email) {
            $res->json(403, ["success" => false, "error" => "You can't access other user's reservation."]);
            return;
        }

        $reservs = $this->reservService->getReservByEmail($email, $status);
        $res->json(200, ["success" => true, "reservs" => $reservs]);
    }

    // get reserv by room num
    public function getReservByRoomNum()
    {
        $req = json_input();
        $res = new HttpResponse();

        if ($_SESSION['user'] == null || $_SESSION['user']['role'] != 'admin') {
            $res->json(401, ["success" => false, "error" => "You are not admin."]);
            return;
        }

        $room_num = $_GET['room_num'] ?? '';
        $status = $_GET['status'] ?? '';

        $reservs = $this->reservService->getReservByRoomNum($room_num, $status);
        $res->json(200, ["success" => true, "reservs" => $reservs]);
    }

    // create reserv
    public function createReserv()
    {
        $req = json_input();
        $res = new HttpResponse();

        if ($_SESSION['user'] == null) {
            $res->json(401, ["success" => false, "error" => "You are not logged in."]);
            return;
        }

        require_once __DIR__ . '/../../util/audit.php';
        if ( $_SESSION['user']['role'] == 'admin') {
            $reserv = new Reservation(
                0,
                $req->json('user_email', ''),
                $req->json('room_num', ''),
                $req->json('status', 'pending'),
                $req->json('memo', '')
            );
            $this->reservService->createReserv($reserv);
            \util\insertAuditRecord($req->json('user_email', ''), 'create_reservation', 'Reservation created for room ' . $req->json('room_num', ''));
            $res->json(200, ["success" => true, "message" => "Reservation created successfully."]);
        } else {
            $reserv = new Reservation(
                $_SESSION['user']['email'],
                $req->json('room_num', ''),
                'pending',
                ''
            );
            $this->reservService->createReserv($reserv);
            \util\insertAuditRecord($_SESSION['user']['email'], 'create_reservation', 'Reservation created for room ' . $req->json('room_num', ''));
            $res->json(200, ["success" => true, "message" => "Reservation created successfully."]);
        }
    }

    // update reserv
    public function updateReserv()
    {
        $req = json_input();
        $res = new HttpResponse();

        if ($_SESSION['user'] == null) {
            $res->json(401, ["success" => false, "error" => "You are not logged in."]);
            return;
        }

        if ( $_SESSION['user']['role'] != 'admin') {
            $res->json(401, ["success" => false, "error" => "You are not admin."]);
            return;
        }

        $reserv = new Reservation(
            $req->json('id', ''),
            $req->json('user_email', ''),
            $req->json('room_num', ''),
            $req->json('status', ''),
            $req->json('memo', '')
        );

        $this->reservService->updateReserv($reserv);
        $res->json(200, ["success" => true, "message" => "Reservation updated successfully."]);
    }

    // cancel reserv
    public function cancelReserv()
    {
        $req = json_input();
        $res = new HttpResponse();

        if ($_SESSION['user'] == null) {
            $res->json(401, ["success" => false, "error" => "You are not logged in."]);
            return;
        }

        $reserv = $this->reservService->getReservById($req->json('id', ''));
        if ($reserv == null) {
            $res->json(404, ["success" => false, "error" => "Reservation not found."]);
            return;
        }

        if ($_SESSION['user']['email'] != $reserv['user_email']) {
            $res->json(403, ["success" => false, "error" => "You can't cancel other user's reservation."]);
        }

        $reservation = new Reservation(
            $reserv['id'],
            $reserv['user_email'],
            $reserv['room_num'],
            'cancelled',
            $reserv['memo']
        );
        $this->reservService->updateReserv($reservation);
        $res->json(200, ["success" => true, "message" => "Reservation cancelled successfully."]);
    }

}