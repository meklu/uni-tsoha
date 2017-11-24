<?php

class Redirect {
	protected static function calc($path) {
		return BASE_DIR . $path;
	}

	protected static function soft($path) {
		header("Location: " . self::calc($path));
	}

	public static function to($path) {
		self::soft($path);
		exit();
	}

	public static function html($path) {
		self::soft($path);
		echo "<a href=\"" . self::calc($path) . "\">Paina tästä</a>, mikäli selaimesi ei uudelleenohjaa sinua.\n";
	}

	public static function view($path) {
		$bv = new View("base", array(
			"title" => "Uudelleenohjaus",
			"content" => static::html($path),
		));
		return $bv;
	}
}
