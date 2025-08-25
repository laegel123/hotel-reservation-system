<?php

class Reservation extends Common
{
    private $userEmail;
    private $roomID;
    private $status;

    public function __construct($userEmail, $roomID)
    {
        $this->userEmail = $userEmail;
        $this->roomID = $roomID;
    }


    public function getUserEmail()
    {
        return $this->userEmail;
    }

    public function setUserEmail($userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    public function getRoomID()
    {
        return $this->roomID;
    }

    public function setRoomID($roomID): void
    {
        $this->roomID = $roomID;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }


}
