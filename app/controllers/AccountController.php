<?php

class AccountController extends Controller {
	public static function index() {
		$data = Account::all();
		$bv = new View("base", array(
			"content" => new View("accounts/list", array(
				"accounts" => $data,
			)),
		));
		echo $bv->render();
	}

	public static function show($id) {
		$a = Account::find($id);
		if (!$a) {
			http_response_code(404);
		}
		$bv = new View("base", array(
			"content" => new View("accounts/show", array(
				"account" => $a,
			)),
		));
		echo $bv->render();
	}

	public static function addview() {
		$bv = new View("base", array(
			"content" => new View("accounts/add"),
		));
		echo $bv->render();
	}

	public static function add() {
		$attr = array();
		$attr["nick"] = $_POST["nick"];
		$attr["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$attr["admin"] = (isset($_POST["admin"]) && $_POST["admin"]) ? true : false;

		$acc = new Account($attr);
		$err = $acc->errors();

		if (count($err) === 0) {
			Account::save($acc);
		}

		$path = "/accounts";
		if (is_int($acc->id)) {
			$path .= "/{$acc->id}";
			if (!isset($_SESSION[$path])) { $_SESSION[$path] = array(); }
			$_SESSION[$path]["success"] = array("Käyttäjä luotu onnistuneesti!");
		} else {
			$path .= "/add";
			if (!isset($_SESSION[$path])) { $_SESSION[$path] = array(); }
			$_SESSION[$path]["errors"] = $err;
			$attr["password"] = $_POST["password"];
			$_SESSION[$path]["attr"] = $attr;
		}
		echo Redirect::view($path)->render();
	}

	public static function editview($id) {
		$a = Account::find($id);
		if (!$a) {
			http_response_code(404);
		}
		$bv = new View("base", array(
			"content" => new View("accounts/edit", array(
				"account" => $a,
			)),
		));
		echo $bv->render();
	}

	public static function edit($id) {
		$acc = Account::find($id);
		if (!$acc) {
			http_response_code(404);
		}
		$attr = array();
		$acc = Account::find($id);
		$acc->nick = $_POST["nick"];
		if (isset($_POST["password"]) && $_POST["password"] !== "") {
			$acc->password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		} else {
			$_POST["password"] = "";
		}
		$acc->admin = (isset($_POST["admin"]) && $_POST["admin"]) ? true : false;

		$err = $acc->errors();

		if (count($err) === 0) {
			Account::update($acc);
		}

		$path = "/accounts";
		if (count($err) === 0) {
			$path .= "/{$acc->id}";
			if (!isset($_SESSION[$path])) { $_SESSION[$path] = array(); }
			$_SESSION[$path]["success"] = array("Muokkaus onnistui!");
		} else {
			$path .= "/edit";
			if (!isset($_SESSION[$path])) { $_SESSION[$path] = array(); }
			$_SESSION[$path]["errors"] = $err;
			$attr["password"] = $_POST["password"];
			$_SESSION[$path]["attr"] = $attr;
		}
		echo Redirect::view($path)->render();
	}
}
