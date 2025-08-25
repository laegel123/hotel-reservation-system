<?php

class Common
{
    private $ID;
    private $createdDate;
    private $modifiedDate;

    public function getID()
    {
        return $this->ID;
    }

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
    }


}
