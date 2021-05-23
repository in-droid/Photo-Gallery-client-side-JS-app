<?php

require_once("model/RoomDB.php");
require_once("ViewHelper.php");

# Controller for handling books
class Controller {

    public static function edit() {
        $edit = isset($_POST["author"]) && !empty($_POST["author"]) && 
            isset($_POST["title"]) && !empty($_POST["title"]) &&
            isset($_POST["price"]) && !empty($_POST["price"]) &&
            isset($_POST["year"]) && !empty($_POST["year"]) &&
            isset($_POST["id"]) && !empty($_POST["id"]);

            $delete = isset($_POST["delete_confirmation"]) && 
                        isset($_POST["id"]) && !empty($_POST["id"]);

            if ($edit) {
                try {
                    RoomDB::update($_POST["id"], $_POST["author"], $_POST["title"], $_POST["price"], $_POST["year"]);
                    // Go to the detail page
                    header(sprintf("Location:%sbook?id=%d", BASE_URL , $_POST["id"]));
                } catch (Exception $e) {
                    $errorMessage = "A database error occured: $e";
                }

            } else if ($delete) {
                try {
                    RoomDB::delete($_POST["id"]);
                    header("Location:" . BASE_URL);
                } catch (Exception $e) {
                    $errorMessage = "A database error occured: $e";
                }

            } else {
                try {
                    // GET id from either GET or POST request
                    $book = RoomDB::get($_REQUEST["id"]);
                } catch (Exception $e) {
                    $errorMessage = "A database error occured: $e";
                }
            }
            $vars = [
                "book" => $book,
                "edit" => $edit,
                "delete" => $delete,

            ];
            if(isset($errorMessage)) {
                $vars["errorMessage"] = $errorMessage;
            }

        ViewHelper::render("view/book-edit.php", $vars);
    }

    public static function search() {
        if (isset($_GET["query"])) {
            $query = $_GET["query"];
            $hits = RoomDB::search($query);
        } else {
            $hits = [];
            $query = "";
        }
        $vars = [
            "hits" => $hits,
            "query" => $query
        ];

        ViewHelper::render("view/book-search.php", $vars);
    }

    public static function getAll() {
        # Reads books from the database
        $variables = ["books" => RoomDB::getAll()];

        # Renders the view and sets the $variables array into view's scope
        ViewHelper::render("view/book-list.php", $variables);
    }

    public static function get() {
        $variables = ["book" => RoomDB::get($_GET["id"])];
        ViewHelper::render("view/book-detail.php", $variables);
    }

    public static function showAddForm($variables = array("author" => "", "title" => "", 
        "price" => "", "year" => "")) {
        ViewHelper::render("view/book-add.php", $variables);
    }

    public static function add() {
        $validData = isset($_POST["author"]) && !empty($_POST["author"]) && 
                isset($_POST["title"]) && !empty($_POST["title"]) &&
                isset($_POST["year"]) && !empty($_POST["year"]) &&
                isset($_POST["price"]) && !empty($_POST["price"]);

        if ($validData) {
            RoomDB::insert($_POST["author"], $_POST["title"], $_POST["price"], $_POST["year"]);
            ViewHelper::redirect(BASE_URL . "book");
        } else {
            self::showAddForm($_POST);
        }
    }

    # TODO: Implement controlers for searching, editing and deleting books
}