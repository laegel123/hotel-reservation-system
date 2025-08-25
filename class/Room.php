<?php
// Clase Room para manejar las habitaciones del hotel
class Room extends Common{
    private $id;
    private $type;
    private $roomNum;
    private $price;
    private $available_yn;
//constructor
    function __construct($id, $type, $roomNum, $price, $available_yn) { //tengo el construct para poder modificar y agregar a la classqu
        $this->id = $id;
        $this->type = $type;
        $this->roomNum = $roomNum;
        $this->price = $price;
        $this->available_yn = $available_yn;
    }
    //Ocupo los getters para poder acceder a los atributos privados de arriba
    public function getType(){
        return $this->type;
    }

    public function getRoomNum(){
        return $this->roomNum;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getAvailableYn(){
        return $this->available_yn;
    }
//Setters
    public function setType($type){
        $this->type = $type;
    } //para modificar el tipo de habitación
    public function setRoomNum($roomNum){
        $this->roomNum = $roomNum;
    } //para modificar el número de habitación

    public function setPrice($price){
        $this->price = $price;
    } //para modificar el precio

    public function setAvailableYn($available_yn){
        $this->available_yn = $available_yn;
    }

    public function getId()
    {
        return $this->id;
    } //para modificar la disponibilidad






}
