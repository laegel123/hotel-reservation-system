<?php

// Clase gestora para el CRUD de habitaciones
class RoomManager {
    private $rooms = []; 

    public function __construct($rooms = []) {
        $this->rooms = $rooms;
    }

    // Crear una nueva habitación
    public function addRoom($roomType, $roomNum, $price, $availability) {
        $newRoom = new Room($roomType, $roomNum, $price, $availability);
        $this->rooms[] = $newRoom;
        return $newRoom;
    }

    // Leer todas las habitaciones
    public function getRooms() {
        return $this->rooms;
    }

    // Buscar habitación por número
    public function getRoomByNum($roomNum) {
        foreach ($this->rooms as $room) {
            if ($room->getRoomNum() == $roomNum) {
                return $room;
            }
        }
        return null;
    }

    // Actualizar habitación
    public function updateRoom($roomNum, $roomType = null, $price = null, $availability = null) {
        $room = $this->getRoomByNum($roomNum);
        if ($room) {
            if ($roomType !== null) $room->setRoomType($roomType);
            if ($price !== null) $room->setPrice($price);
            if ($availability !== null) $room->setAvailability($availability);
            return true;
        }
        return false;
    }

    // Eliminar habitación
    public function deleteRoom($roomNum) {
        foreach ($this->rooms as $key => $room) {
            if ($room->getRoomNum() == $roomNum) {
                unset($this->rooms[$key]);
                $this->rooms = array_values($this->rooms);
                return true;
            }
        }
        return false;
    }
}

$rooms = [
    new Room("Single", 101, 100, true),
    new Room("Double", 102, 150, true),
    new Room("Suite", 103, 200, false),
    new Room("Deluxe", 104, 250, true)
];
$roomManager = new RoomManager($rooms);

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
