<?php

require_once "DBInit.php";

class RoomDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT rid, name, typeOfRoom, price FROM rooms");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getHotelRooms($hid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT rid, name, typeOfRoom, price FROM rooms WHERE hid = :hid");
        $statement->bindParam(":hid", $hid);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function insert($type, $name, $hid, $price) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO rooms(typeOfRoom, name, hid, price) VALUES (:typeOfRoom, :name, :hid, :price)");
        $statement->bindParam(":typeOfRoom", $type);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":hid", $hid);
        $statement->bindParam(":price", $price);

        $statement->execute();
    }

    public static function getRoom($rid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT rid, name, typeOfRoom, price FROM rooms WHERE rid = :rid");
        $statement->bindParam(":rid", $rid);
        $statement->execute();

        return $statement->fetch();
    }

    public static function updateRoom($rid, $name, $type, $price) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE rooms SET name = :name,
            typeOfRoom = :type, price = :price WHERE rid = :rid");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":type", $type);
        $statement->bindParam(":price", $price);
        $statement->bindParam(":rid", $rid, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function deleteRoom($rid) {
        $db = DBInit::getInstance();
        try {
            $statement = $db->prepare("DELETE FROM rooms WHERE rid = :rid");
            $statement->bindParam(":rid", $rid, PDO::PARAM_INT);
            $statement->execute();
        } catch(Exception $e) {
            return false;
        }
        return true;
    }

    public static function getHotelName($rid) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT hotels.name FROM rooms JOIN hotels USING (hid) WHERE rid = :rid;");
        $statement->bindParam(":rid", $rid, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn(0);
    }

    public static function checkReservation($rid, $start, $end) {
        $db = DBInit::getInstance();

        $sql = $sql = "SELECT COUNT(rid) FROM reservations WHERE (DATE( :start) BETWEEN fromDate AND toDate OR DATE( :end) BETWEEN fromDate AND toDate OR fromDate BETWEEN DATE(:start) AND DATE(:end) OR toDate BETWEEN DATE(:start) AND DATE(:end)) AND rid = :rid;";
        $statement = $db->prepare($sql);
        $statement->bindParam(":rid", $rid);
        $statement->bindParam(":start", $start);
        $statement->bindParam(":end", $end);

        $statement->execute();
        return $statement->fetchColumn(0) == 0;
    }

    public static function avilableRooms($start, $end) {
        $db = DBInit::getInstance();

        $sql = "SELECT rid FROM reservations WHERE (:start) NOT BETWEEN fromDate AND toDate AND DATE(:end) NOT BETWEEN fromDate AND toDate AND fromDate NOT BETWEEN DATE(:start) AND DATE(:end) AND toDate NOT BETWEEN DATE(:start) AND DATE(:end) UNION SELECT rid FROM rooms WHERE rid NOT IN ( SELECT rid FROM reservations)";
        $statement = $db->prepare($sql);
        $statement->bindParam(":start", $start);
        $statement->bindParam(":end", $end);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public static function getPrice($rid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT price FROM rooms WHERE rid = :rid");
        $statement->bindParam(":rid", $rid);
        $statement->execute();

        return $statement->fetchColumn(0);
    }

    public static function reserve($uid, $rid, $start, $end) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO reservations (uid, rid, fromDate, toDate) VALUES (:uid, :rid, :fromDate, :toDate)");
        $statement->bindParam(":uid", $uid);
        $statement->bindParam(":rid", $rid);
        $statement->bindParam(":fromDate", $start);
        $statement->bindParam(":toDate", $end);
        try {
            $statement->execute();
        }
        catch(Exception $e) {
            return false;
        }
        return true;
    }

    public static function removeReservation($uid, $rid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM reservations WHERE uid = :uid AND rid = :rid");
        $statement->bindParam(":uid", $uid);
        $statement->bindParam(":rid", $rid);
        $statement->execute();
    }

    public static function getReservations($rid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT username, fromDate, toDate FROM reservations JOIN user USING (uid) WHERE rid = :rid");
        $statement->bindParam(":rid", $rid);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getUsersRooms($uid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT rid, name, price, hid, typeOfRoom FROM reservations JOIN rooms USING (rid) WHERE uid = :uid");
        $statement->bindParam(":uid", $uid);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function reservedByUser($uid, $rid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT COUNT(rid) FROM reservations WHERE uid = :uid AND rid = :rid");
        $statement->bindParam(":uid", $uid);
        $statement->bindParam(":rid", $rid);
        $statement->execute();

        return $statement->fetchColumn(0) == 1;
    }
    public static function getHotelInfo($rid) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT hotels.* FROM rooms JOIN hotels USING (hid) WHERE rid = :rid;");
        $statement->bindParam(":rid", $rid, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(0);
    }

}
//var_dump(RoomDB::checkReservation(12,'2021-05-23', '2021-05-25'));
