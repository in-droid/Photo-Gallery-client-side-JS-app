<?php
session_start();

require_once("controller/Controller.php");
require_once("controller/UserController.php");
require_once("controller/HotelController.php");
require_once("controller/RoomController.php");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/styles/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");

# Define a global constant pointing to the URL of the application
define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");

# Request path after /index.php/ with leading and trailing slashes removed
$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

# The mapping of URLs. It is a simple array where:
# - keys represent URLs
# - values represent functions to be called when a client requests that URL
$urls = [
    "user/login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::showLoginForm(array());
        }
    },
    "user/register" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::registerUser();
        } else {
            UserController::showRegisterForm();
        }
    },
    "hotel/register" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::registerHotel();
        } else {
            UserController::showRegisterFormHotel(array());
        }
    },
    "hotel" => function() {
       HotelController::get();
    },
    "hotel/room/add" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            HotelController::addRoom();
        }
        else {
            HotelController::showAddForm("");
        }
    },
    "hotel/room/edit" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            HotelController::editRoom();
        }
        else {
            HotelController::showEditForm();
        }
    },
    "hotel/room" => function() {
        HotelController::index();
    },
    "user/logout" => function () {
        UserController::logout();
    },
    "hotel/room/delete" => function() {
        HotelController::deleteRoom();
    },
    "room" => function() {
        RoomController::index();
    },
    "" => function() {
        ViewHelper::redirect(BASE_URL . "room");
    },

    "room/reserve" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            RoomController::reserve();
        }
        else {
            ViewHelper::redirect(BASE_URL ."room");
        }
    },
    "api/room/check_reservation" => function() {
        RoomController::checkReservation();
    },
    "room/period" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            RoomController::avilableRooms();
        }
        else {
            RoomController::showPeriodSelection();
        }
    },
    "room/cancel" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            RoomController::cancelReservation();
        }
        else {
            ViewHelper::redirect(BASE_URL . "room");
        }
    },
    "hotel/search" => function() {
        HotelController::searchRooms();
    },
    /*
    "room/search" => function() {
        RoomController::search();
    },
    */
    "hotel/room/search" => function() {
        HotelController::searchApi();
    },
    /*
    "room/search/api" => function() {
        RoomController::searchApi();
    },
    */
    "user/reservations" => function() {
        RoomController::getUsersRooms();
    }
];

    // TODO: Add router entries for 1) search, 2) book/edit and 3) book/delete


# The actual router.
# Tries to invoke the function that is mapped for the given path
try {
    if (isset($urls[$path])) {
        # Great, the path is defined in the router
        $urls[$path](); // invokes function that calls the controller
    } else {
        # Fail, the path is not defined. Show an error message.
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    # Provisional: whenever there is an exception, display some info about it
    # this should be disabled in production
    ViewHelper::error400($e);
} finally {
    exit();
}
