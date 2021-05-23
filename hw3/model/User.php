<?php

class User {
	public static function login($user) {
		$_SESSION["user"] = $user;
	}

	public static function logout() {
		session_destroy();
	}

	public static function isLoggedIn() {
		return isset($_SESSION["user"]);
	}

	public static function getUsername() {
		return $_SESSION["user"]["username"];
	}

    public static function isAdmin() {
        return UserDB::isAdmin(self::getUsername());
    }

    public static function getHid() {
        return UserDB::getHid(self::getUsername());
    }
}