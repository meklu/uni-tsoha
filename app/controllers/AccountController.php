<?php

class AccountController extends Controller {
	public static function index() {
		$a = new Account();
		$data = $a->all();
		$bv = new View("base", array(
			"content" => new View("accounts/list", array(
				"accounts" => $data,
			)),
		));
		echo $bv->render();
	}

	public static function show($id) {
		$a = new Account();
		$bv = new View("base", array(
			"content" => new View("accounts/show", array(
				"account" => $a->find($id),
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
		$acc = $acc->save();

		$path = "/accounts";
		if ($acc && is_int($acc->id)) {
			$path .= "/{$acc->id}";
		}
		$bv = new View("base", array(
			"title" => "Uudelleenohjaus",
			"content" => Redirect::html($path),
		));
		echo $bv->render();
	}
}
