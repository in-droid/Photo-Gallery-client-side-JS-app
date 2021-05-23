<?php
/*
class UserController {

    public static function showLoginForm() {
       ViewHelper::render("view/user-login.php");
    }

    public static function login() {
       if (UserDB::validLoginAttempt($_POST["username"], $_POST["password"])) {
            $vars = [
                "username" => $_POST["username"],
                "password" => $_POST["password"]
            ];

            ViewHelper::render("view/book-list.php", $vars);
       } else {
            ViewHelper::redirect(BASE_URL . "book");
            /*
            ViewHelper::render("view/book-edit.php", [
               "errorMessage" => "Invalid username or password."
            ]);
            
       }
    }
}
*/
require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("model/HotelDB.php");
require_once("model/User.php");

class UserController {

    public static function showLoginForm($errors) {
       ViewHelper::render("view/user-login.php", $errors);
    }

    public static function login() {
      $rules = [
         "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
         "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
     ];

     $data = filter_input_array(INPUT_POST, $rules);
     $user = UserDB::getUser($data["username"], $data["password"]);
     $errorMessage =  empty($data["username"]) || empty($data["password"]) || $user == null ? "Invalid username or password." : "";

     if (empty($errorMessage)) {
         User::login($user);

         $vars = [
             "username" => $data["username"],
             "password" => $data["password"]
         ];

         if(User::isAdmin()) {
            ViewHelper::redirect(BASE_URL . "hotel");
         }
         else {
            ViewHelper::redirect(BASE_URL . "room/period");
         }
        // ViewHelper::render("view/user-login-success.php", $vars);
     } else {
         ViewHelper::render("view/user-login.php", [
             "errorMessage" => $errorMessage,
         ]);
     }
 }

    public static function showRegisterForm() {
       ViewHelper::render("view/user-register.php");
    }

    public static function registerUser() {
      $rules = [
         "username" => [
            "filter" => FILTER_CALLBACK,
            "options" => function ($value) { return ctype_alnum($value); }
         ],
         "password" => FILTER_SANITIZE_SPECIAL_CHARS,
         "passwordRepeat" => FILTER_SANITIZE_SPECIAL_CHARS
      ];
      $data = filter_input_array(INPUT_POST, $rules);

      $errors["username"] = $data["username"] === false ? "Username must be alphanumeric" : "";
      $errors["password"] = "";
      $errors["passwordRepeat"] = "";
      $isDataValid = true;
      foreach($errors as $error) {
         $isDataValid = $isDataValid && empty($error);
      }
      $hashed_password = password_hash($data["password"], PASSWORD_DEFAULT);
      if ($isDataValid) {
         if ($_POST["password"] != $_POST["passwordRepeat"]) {
            ViewHelper::render("view/user-register.php", [
               "errorMessage" => "The passwords don't match"
            ]);
         }
         else if(UserDB::insertUser($_POST["username"], $hashed_password)) {
            ViewHelper::redirect(BASE_URL . "user/login");
         }
         else {
            ViewHelper::render("view/user-register.php", [
            "errorMessage" => "Username already exists"
            ]);
         }
      }
      else {
         ViewHelper::redirect("view/user-register.php", [
            "errorMessage" => $errors["username"]]);
      }
   }

   public static function registerHotel() {
      $rules = [
         "username" => [
            "filter" => FILTER_CALLBACK,
            "options" => function ($value) { return ctype_alnum($value); }
         ],
         "password" => FILTER_SANITIZE_SPECIAL_CHARS,
         "passwordRepeat" => FILTER_SANITIZE_SPECIAL_CHARS,
         "hotel-name" => FILTER_SANITIZE_SPECIAL_CHARS,
         "hotel-address" => [
            "filter" => FILTER_CALLBACK,
            "options" => function ($value) { return self::validateAddress($value);}
         ]
      ];

      $data = filter_input_array(INPUT_POST, $rules);

      $errors["username"] = $data["username"] === false ? "Username must be alphanumeric" : "";
      $errors["password"] = "";
      $errors["passwordRepeat"] = "";
      $errors["hotel-name"] = empty($data["hotel-name"]) ? "Provide a valid hotel name" : "";
      $errors["hotel-address"] = empty($data["hotel-address"]) ? "Provide a valid address format" : "";
      $isDataValid = true;
      foreach($errors as $error) {
         $isDataValid = $isDataValid && empty($error);
      }
      if ($isDataValid) {
         if ($_POST["password"] != $_POST["passwordRepeat"]) {
               $errors["password"] = "The passwords don't match";
         }
         else if(!UserDB::isRegistered($_POST["username"])) {
            HotelDB::insert($data["hotel-name"], $_POST["hotel-address"]);
            $hid = HotelDB::getID($data["hotel-name"]);

            //fix this !!!!!!!!!!!!! so works with hotels with same names!!!
            $hashed_password = password_hash($data["password"], PASSWORD_DEFAULT);
            UserDB::insertAdmin($_POST["username"], $hashed_password, $hid);
            ViewHelper::redirect(BASE_URL . "user/login");
            return;
         }
         else {
               $errors["user"] = "Username already exists";
         }
      }
      self::showRegisterFormHotel($errors);


   }

   public static function showRegisterFormHotel($errors) {
      ViewHelper::render("view/hotel-register.php",["errors" => $errors]);
   }

   public static function logout() {
      User::logout();
      ViewHelper::redirect(BASE_URL . "user/login");
  }

   private static function validateAddress($address) {
      $addrSeparated = explode("\n" ,$address);

      if (sizeof($addrSeparated) != 3) {
         return false;
      }

      $street = explode(" " ,$addrSeparated[0]);
      if (!is_numeric(end($street)) || !is_numeric($addrSeparated[1])) {
         return false;
      }
      return true;

  }
}