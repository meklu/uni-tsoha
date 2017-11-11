<?php

class Redirect {
	public static function to($path) {
		header("Location: " . BASE_DIR . $path);
		exit();
	}
}
