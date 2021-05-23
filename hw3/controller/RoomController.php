<?php

require_once("model/User.php");
require_once("model/Room.php");

class RoomController {

    public static function index() {
        if (isset($_GET["rid"])) {
            $vars = ["room" => RoomDB::getRoom($_GET["rid"]),
                    "hotel" => RoomDB::getHotelInfo($_GET["rid"])];
            if (User::isLoggedIn() && isset($_SESSION["period"]) && !empty($_SESSION["period"])) {
                $vars["totalPrice"] = Room::calcuateTotalPrice($_GET["rid"],
                                            $_SESSION["period"]["start"], $_SESSION["period"]["end"]);
                
            
            $cond = RoomDB::reservedByUser($_SESSION["user"]["uid"], $_GET["rid"]);
            if ($cond == true) {
                $cond = -10;
            }
            else $cond = 10;
            $vars["cond"] = $cond;
        }
            ViewHelper::render("view/room-detail.php", $vars);
        } else {
            ViewHelper::render("view/room-list.php", ["rooms" => RoomDB::getAll()]);
        }
    }

    public static function cancelReservation() {
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "room");
            return;
        }
        if (isset($_POST["rid"]) && !empty($_POST["rid"])) {
            RoomDB::removeReservation($_SESSION["user"]["uid"], $_POST["rid"]);
            echo "You canceled the reservation";
        }
    }

    public static function reserve() {
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "room");
            return;
        }
        if (isset($_POST["rid"]) && !empty($_POST["rid"])) {
            $reserved = RoomDB::checkReservation($_POST["rid"], $_SESSION["period"]["start"], $_SESSION["period"]["end"]);
            if ($reserved) {
                RoomDB::reserve($_SESSION["user"]["uid"], $_POST["rid"], $_SESSION["period"]["start"], $_SESSION["period"]["end"]);
                echo "Reservation succesful";
            }
            else {
                echo "There was some problem when making the reservation, please try again later";
            }
        }
        else {
            ViewHelper::redirect(BASE_URL . "room");
        }

    }

    public static function showReserveForm($errorMessasge) {
        if (isset($_GET["rid"])) {
            ViewHelper::render("view/room-detail.php", [
                "errorMessage" => $errorMessasge,
                "room" => $_GET["rid"],
                "cond" => 0]);
        }
        else {
            ViewHelper::redirect("room");
        }
    }

    public static function checkReservation() {
        $rules = [

            "start" => [
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) {
                    $date = explode("-", $value);

                    if (checkdate($date[1], $date[2], $date[0])) {
                        return $value;
                    } else {
                        return false;
                    }
                }
            ],
            "end" =>  [
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) {
                    $date = explode("-", $value);

                    if (checkdate($date[1], $date[2], $date[0])) {
                        return $value;
                    } else {
                        return false;
                    }
                }
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["start"] = $data["start"] === false ? "Invalid start date" : "";
        $errors["end"] = $data["end"] === false ? "Invalid end date" : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            $today = date("Y-m-d");
            if ($_POST["start"] < $today || $_POST["end"] <= $today || strtotime($_POST["end"]) < strtotime($_POST["start"])) {
                $errors["date"] = "Invalid start or end date";
                self::showReserveForm($errors);
                return false;
            }
            else {
                RoomDB::checkReservation($_POST["rid"], $_POST["start"], $_POST["end"]);
            }
        } else {
            self::showReserveForm($errors);
        }

    }

    public static function showPeriodSelection($errors=array()) {
        if (isset($_SESSION["period"]) && !empty($_SESSION["period"])) {
            $avilableRid = RoomDB::avilableRooms($_SESSION["period"]["start"], $_SESSION["period"]["end"]);
                $rooms = array();
                foreach($avilableRid as $rid) {
                    $rooms[] = RoomDB::getRoom($rid);
                }
                ViewHelper::render("view/room-list.php", ["rooms" => $rooms]);
        }
        else {
            ViewHelper::render("view/period-form.php",["errors" => $errors]);
        }
    }

    public static function getUsersRooms() {
        if (User::isLoggedIn()) {
            $rooms = RoomDB::getUsersRooms($_SESSION["user"]["uid"]);
            ViewHelper::render("view/room-list.php", ["rooms" => $rooms]);
        }
        else {
            ViewHelper::redirect(BASE_URL . "room");
        }
    }

    public static function avilableRooms() {
        if (!User::isLoggedIn()) {
            ViewHelper::redirect("room");
            return;
        }
        /*
        if(!isset($_POST["start"]) || empty($_POST["start"])
            || isset($_POST["end"]) || empty($_POST["end"])) {
                self::showPeriodSelection(["error" => "Empty input"]);
                return false;
            }
            */
        $rules = [

            "start" => [
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) {
                    $date = explode("-", $value);

                    if (checkdate($date[1], $date[2], $date[0])) {
                        return $value;
                    } else {
                        return false;
                    }
                }
            ],
            "end" =>  [
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) {
                    $date = explode("-", $value);

                    if (checkdate($date[1], $date[2], $date[0])) {
                        return $value;
                    } else {
                        return false;
                    }
                }
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["start"] = $data["start"] === false ? "Invalid start date" : "";
        $errors["end"] = $data["end"] === false ? "Invalid end date" : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            $today = date("Y-m-d");
            if ($data["start"] < $today || $data["end"] <= $today || strtotime($data["end"]) <= strtotime($data["start"])) {
                $errors["date"] = "Invalid start or end date";
                self::showPeriodSelection($errors);
                return false;
            }
            else {
                $avilableRid = RoomDB::avilableRooms($data["start"], $data["end"]);
                $_SESSION["period"]["start"] = $data["start"];
                $_SESSION["period"]["end"] = $data["end"];
                $rooms = array();
                foreach($avilableRid as $rid) {
                    $rooms[] = RoomDB::getRoom($rid);
                }
                ViewHelper::render("view/room-list.php", ["rooms" => $rooms]);
            }
        } else {
            self::showPeriodSelection($errors);
        }
    }
}