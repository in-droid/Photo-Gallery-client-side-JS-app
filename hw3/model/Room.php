<?php
require_once("model/RoomDB.php");
class Room {

    public static function calcuateTotalPrice($rid, $start, $end) {
        $price = RoomDB::getPrice($rid);
        $numberOfDays = round((strtotime($end) - strtotime($start)) / (60 * 60 * 24));
        return $price * $numberOfDays;
    }
}