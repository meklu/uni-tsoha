<?php

class Database {
	protected static $dbcache = null;

	public static function conn() {
		try {
			if (self::$dbcache === null) {
				self::$dbcache = new PDO("pgsql:");
			}
			return self::$dbcache;
		} catch (PDOException $e) {
			die("DB failure");
		}
	}
}
