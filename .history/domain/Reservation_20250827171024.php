<?php declare(strict_types=1);

namespace domain;

require_once './domain/Common.php';

use Common;

class Reservation extends Common
{
    private $id;
    private $user_email;
    private $room_num;
    private $memo;
    private $status;

    public function __construct($id, $user_email, $room_num, $status, $memo = '')
    {
        $this->id = $id;
        $this->user_email = $user_email;
        $this->room_num = $room_num;
        $this->status = $status;
        $this->memo = $memo;
    }


    public function getUserEmail()
    {
        return $this->user_email;
    }

    public function setUserEmail($user_email): void
    {
        $this->user_email = $user_email;
    }

    public function getRoomNum()
    {
        return $this->room_num;
    }

    public function setRoomID($room_num): void
    {
        $oldRoom = $this->room_num;
        $this->room_num = $room_num;
        require_once __DIR__ . '/../util/audit.php';
        generateAuditRecord($this->user_email, 'update_room', 'Room changed from ' . $oldRoom . ' to ' . $room_num);// esto agregue yo y tengo que estudiarlo

    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    
        
    }

    public function getId()
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getMemo()
    {
        return $this->memo;
    }

    public function setMemo($memo): void
    {
        $oldMemo = $this->memo;
        $this->memo = $memo;
        require_once __DIR__ . '/../util/audit.php';
        generateAuditRecord($this->user_email, 'update_memo', 'Memo changed from "' . $oldMemo . '" to "' . $memo . '"');
    }




}
