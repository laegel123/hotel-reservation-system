<?php
$rooms = [
    new Room("Single", 101, 100, true),
    new Room("Double", 102, 150, true),
    new Room("Suite", 103, 200, false),
    new Room("Deluxe", 104, 250, true)];

// Clase Room para manejar las habitaciones del hotel
class Room{
    private $RoomType;
    private $RoomNum;
    private $Price;
    private $Availability;
//constructor
    function __construct($RoomType, $RoomNum, $Price, $Availability) { //tengo el construct para poder modificar y agregar a la classqu
        $this->RoomType = $RoomType;
        $this->RoomNum = $RoomNum;
        $this->Price = $Price;
        $this->Availability = $Availability;
    }
    //Ocupo los getters para poder acceder a los atributos privados de arriba
    public function getRoomType(){
        return $this->RoomType;
    }

    public function getRoomNum(){
        return $this->RoomNum;
    }

    public function getPrice(){
        return $this->Price;
    }

    public function getAvailability(){
        return $this->Availability;
    }
//Setters
    public function setRoomType($roomType){
        $this->RoomType = $roomType;
    } //para modificar el tipo de habitación
    public function setRoomNum($roomNum){
        $this->RoomNum = $roomNum;
    } //para modificar el número de habitación

    public function setPrice($price){
        $this->Price = $price;
    } //para modificar el precio

    public function setAvailability($availability){
        $this->Availability = $availability;
    } //para modificar la disponibilidad

    //Funcion para checar Availability
    public function ava(){
        if($this->Availability > 0){ //si es mas de cero significa que si esta disponible
            $this->Availability--;
            return true; //arroja true
        }
        return false; //else arroja false y no hay disponibles
    }

    // Función para reservar habitación
    public function reserveRoom() {
        // Verificar si la habitación está disponible
        if ($this->Availability) {
            $this->Availability = false;
            return true; // Si la reserva fue exitosa la cambia la availability a false
        }
        return false; // Ya está ocupada
    }
    public function checkOut() { //funcion para hacer el checkout 
        $this->Availability = true;
        return true;
    }

}
