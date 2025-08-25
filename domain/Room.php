<?php declare(strict_types=1);

namespace domain;

require_once './domain/Common.php';

use Common;

class Room extends Common{
    private $room_num;
    private $type;
    private $description;
    private $capacity;
    private $price;
    private $image;
    private $available_yn;
//constructor
    function __construct($room_num, $type, $description, $capacity, $price, $image, $available_yn) { //tengo el construct para poder modificar y agregar a la classqu
        $this->room_num = $room_num;
        $this->type = $type;
        $this->description = $description;
        $this->capacity = $capacity;
        $this->price = $price;
        $this->image = $image;
        $this->available_yn = $available_yn;
    }
    //Ocupo los getters para poder acceder a los atributos privados de arriba
    public function getType(){
        return $this->type;
    }

    public function getRoomNum(){
        return $this->room_num;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getAvailableYn(){
        return $this->available_yn;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function getImage()
    {
        return $this->image;
    }






//Setters
    public function setType($type){
        $this->type = $type;
    } //para modificar el tipo de habitación
    public function setRoomNum($room_num){
        $this->room_num = $room_num;
    } //para modificar el número de habitación

    public function setPrice($price){
        $this->price = $price;
    } //para modificar el precio

    public function setAvailableYn($available_yn){
        $this->available_yn = $available_yn;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function setCapacity($capacity): void
    {
        $this->capacity = $capacity;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

}
