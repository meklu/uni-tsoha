<?php

class Database {
	public static function conn() {
		try {
			$db = new PDO("pgsql:");
			return $db;
		} catch (PDOException $e) {
			die("DB failure");
		}
	}
}
