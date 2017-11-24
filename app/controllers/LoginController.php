<?php

class LoginController extends Controller {
	public static function loginview() {
		$bv = new View("base", array(
			"content" => new View("login"),
		));
		echo $bv->render();
	}

	public static function login() {
		$nick = $_POST["user"];
		$password = $_POST["pass"];
		$acc = Account::findByNick($nick);
		$data = array();
		if (!isset($_SESSION["afterlogin"])) {
			$_SESSION["afterlogin"] = "/";
		}
		$path = $_SESSION["afterlogin"];
		if ($acc && $acc->verifyPassword($password)) {
			$_SESSION["userid"] = $acc->id;
			$data["success"] = array("Sinut on kirjattu sisään onnistuneesti!");
			$_SESSION["afterlogin"] = "/";
		} else {
			$path = REQ_URL;
			$data["errors"] = array("Sisäänkirjautuminen epäonnistui. Tarkista kirjautumistiedot.");
			$data["attr"] = array("nick" => $nick);
		}
		echo Redirect::view($path, $data)->render();
	}
}
