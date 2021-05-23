<?php
require_once "DBInit.php";
class HotelDB {
    public static function insert($hotelName, $hotelAddr) {
        $dbh = DBInit::getInstance();
        $addrSplitted = explode("\n", $hotelAddr);
        $street = explode(" ", $addrSplitted[0]);
        $streetNumber = end($street);
        array_pop($street);
        $street = join(" ",$street);
        $postalCode = $addrSplitted[1];
        $city = $addrSplitted[2];
        $statement = $dbh->prepare("INSERT INTO hotels (name, streetName, streetNumber, postalCode, city)
                                    VALUES (:name, :streetName, :streetNumber, :postalCode, :city)");
        $statement->bindParam(":name", $hotelName);
        $statement->bindParam(":streetName", $street);
        $statement->bindParam(":streetNumber", $streetNumber);
        $statement->bindParam(":postalCode", $postalCode);
        $statement->bindParam("city", $city);
        $statement->execute();
    }

    public static function getID($hotelName) {
        $dbh = DBInit::getInstance();
        $statement = $dbh->prepare("SELECT hid FROM hotels WHERE name = :name");
        $statement->bindParam(":name", $hotelName);
        $statement->execute();
        $hid = $statement->fetchColumn(0);
        return intval($hid);
    }

    public static function getName($hid) {
        $dbh = DBInit::getInstance();
        $statement = $dbh->prepare("SELECT name FROM hotels WHERE hid = :hid");
        $statement->bindParam(":hid", $hid);
        $statement->execute();
        $hid = $statement->fetchColumn(0);
        return $hid;
    }

    public static function containsRoom($hid, $rid) {
        $dbh = DBInit::getInstance();
        $statement = $dbh->prepare("SELECT COUNT(hid) FROM hotels JOIN rooms USING (hid) WHERE rid = :rid AND hid = :hid");
        $statement->bindParam(":hid", $hid);
        $statement->bindParam(":rid", $rid);
        $statement->execute();
        return $statement->fetchColumn(0) == 1;
    }

    public static function search($hid, $query) {
        $dbh = DBInit::getInstance();
        $statement = $dbh->prepare("SELECT * FROM rooms
            WHERE hid = :hid AND (name LIKE :query OR typeOfRoom LIKE :query)");
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->bindParam(":hid", $hid);
        $statement->execute();

        return $statement->fetchAll();
    }
}

