<?php

require_once "DBInit.php";

class UserDB {

    /*
    // Returns true if a valid combination of a username and a password are provided.
    public static function validLoginAttempt($username, $password) {
        $dbh = DBInit::getInstance();


        $statement = $dbh->prepare("SELECT COUNT(id) FROM user WHERE username = :username AND password = :password");
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->execute();

        return $statement->fetchColumn(0) == 1;
    }
    */

    public static function getUser($username, $password) {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT uid, username, password FROM user
            WHERE username = :username");
        $stmt->bindValue(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch();
        if (empty($user)) {
            $stmt2 = $dbh->prepare("SELECT id, username, password, hid FROM hoteladmin
            WHERE username = :username");
            $stmt2->bindValue(":username", $username);
            $stmt2->execute();
            $user = $stmt2->fetch();
            if(empty($user)) {
                return false;
            }
        }
        if (password_verify($password, $user["password"])) {
            unset($user["password"]);
            return $user;
        }
        return false;
    }




    public static function insertUser($username, $password) {
        $dbh = DBInit::getInstance();
        $statement = $dbh->prepare("SELECT COUNT(uid) FROM user WHERE username = :username");
        $statement->bindParam(":username", $username);
        $statement->execute();
        if ($statement->fetchColumn(0) == 1) {
            return false;
        }
        $statement = $dbh->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->execute();
        return true;
    }

    public static function isRegistered($username) {
        $dbh = DBInit::getInstance();
        $statementUsers = $dbh->prepare("SELECT COUNT(uid) FROM user WHERE username = :username");
        $statementUsers->bindParam(":username", $username);
        $statementUsers->execute();

        $statementHotelAdmins = $dbh->prepare("SELECT COUNT(id) FROM hoteladmin WHERE username =:username");
        $statementHotelAdmins->bindParam(":username", $username);
        $statementHotelAdmins->execute();
        $userCond = $statementUsers->fetchColumn(0) == 1;
        $hAdminsCond = $statementHotelAdmins->fetchColumn(0) == 1;
        return ($userCond || $hAdminsCond);

    }

    public static function insertAdmin($username, $password, $hid) {
        $dbh = DBInit::getInstance();
        $statement = $dbh->prepare("INSERT INTO hoteladmin (hid,username, password)
                                    VALUES (:hid, :username, :password)");
        $statement->bindParam(":hid", $hid);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->execute();
    }

    public static function isAdmin($username) {
        $dbh = DBInit::getInstance();

        $statement = $dbh->prepare("SELECT COUNT(id) FROM hoteladmin WHERE username = :username");
        $statement->bindParam(":username", $username);
        $statement->execute();

        return $statement->fetchColumn(0) == 1;
    }

    public static function getHid($username) {
        $dbh = DBInit::getInstance();

        $statement = $dbh->prepare("SELECT hid FROM hoteladmin WHERE username = :username");
        $statement->bindParam(":username", $username);
        try {
            $statement->execute();
            return $statement->fetchColumn(0);
        }
        catch(Exception $e) {
            echo $e;
        }
    }
}