<?php

class Controller {
	public static function get_current_user() {
		if (isset($_SESSION["userid"])) {
			$user = Account::find($_SESSION["userid"]);
			if (!$user) {
				unset($_SESSION["userid"]);
			}
			return $user;
		}
		return null;
	}

	public static function check_logged_in() {
		$user = self::get_current_user();
		if ($user) {
			return $user;
		}
		$_SESSION["afterlogin"] = REQ_URL;
		echo Redirect::view("/login")->render();
		exit();
	}
}
