<?php

class Redirect {
	protected static function calc($path) {
		return BASE_DIR . $path;
	}

	protected static function soft($path, $userdata = array()) {
		header("Location: " . self::calc($path));
		if (!isset($_SESSION[$path])) { $_SESSION[$path] = array(); }
		$_SESSION[$path] = array_merge_recursive($_SESSION[$path], $userdata);
	}

	public static function to($path, $userdata = array()) {
		self::soft($path, $userdata);
		exit();
	}

	public static function html($path, $userdata = array()) {
		self::soft($path, $userdata);
		return "<a href=\"" . self::calc($path) . "\">Paina tästä</a>, mikäli selaimesi ei uudelleenohjaa sinua.\n";
	}

	public static function view($path, $userdata = array()) {
		$bv = new View("base", array(
			"title" => "Uudelleenohjaus",
			"content" => static::html($path, $userdata),
		));
		return $bv;
	}
}
