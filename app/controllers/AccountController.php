<?php

class AccountController extends Controller {
	public static function index() {
		$user = static::check_logged_in();
		if ($user->admin) {
			$data = Account::all();
		} else {
			$data = array($user);
		}
		$bv = new View("base", array(
			"content" => new View("accounts/list", array(
				"accounts" => $data,
			)),
		));
		echo $bv->render();
	}

	public static function show($id) {
		$user = static::check_logged_in();
		$a = null;
		if ($user->id . "" === $id . "") {
			$a = $user;
		} else if ($user->admin) {
			$a = Account::find($id);
		}
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
		$user = static::check_logged_in();
		if (!$user->admin) {
			http_response_code(403);
			ErrorController::error("Toiminto ei ole sallittu!");
			return;
		}

		$bv = new View("base", array(
			"content" => new View("accounts/add"),
		));
		echo $bv->render();
	}

	public static function add() {
		$user = static::check_logged_in();
		if (!$user->admin) {
			http_response_code(403);
			ErrorController::error("Toiminto ei ole sallittu!");
			return;
		}

		$attr = array();
		$attr["nick"] = $_POST["nick"];
		$attr["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$attr["admin"] = (isset($_POST["admin"]) && $_POST["admin"]) ? true : false;

		$acc = new Account($attr);
		$err = $acc->errors();

		/* Tätä ei välttämättä ole mielekästä validoida muokatessa, koska tuolloin
		 * tyhjällä salasanalla voidaan helposti tarkoittaa salasanan muokkaamatta
		 * jättämistä kuten sovelluksessamme tehdäänkin. Tämän tosin voisi
		 * kontekstiparametrittaa mallille itselleen esim. $account->errors("add")
		 * Olemme tosin ongelmien äärellä, sillä plaintext-salasanaa ei koskaan
		 * talleteta Account-olioon. Jippii? Erillinen staattinen metodi mallille
		 * mielivaltaista plaintext-passua varten lienee OK vaihtoehto. */
		$err = array_merge($err, Account::_validate_plaintext_password($_POST["password"]));

		if (count($err) === 0) {
			Account::save($acc);
		}

		$path = "/accounts";
		$data = array();
		if (is_int($acc->id)) {
			$path .= "/{$acc->id}";
			$data["success"] = array("Käyttäjä luotu onnistuneesti!");
		} else {
			$path .= "/add";
			if (count($err) === 0) {
				$err[] = "Tietokantavirhe";
			}
			$data["errors"] = $err;
			$attr["password"] = $_POST["password"];
			$data["attr"] = $attr;
		}
		echo Redirect::view($path, $data)->render();
	}

	public static function editview($id) {
		$user = static::check_logged_in();
		$a = null;
		if ($user->id . "" === $id . "") {
			$a = $user;
		} else if ($user->admin) {
			$a = Account::find($id);
		} else {
			http_response_code(403);
			ErrorController::error("Toiminto ei ole sallittu!");
			return;
		}
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
		$user = static::check_logged_in();
		$acc = null;
		if ($user->id . "" === $id . "") {
			$acc = $user;
		} else if ($user->admin) {
			$acc = Account::find($id);
		} else {
			http_response_code(403);
			ErrorController::error("Toiminto ei ole sallittu!");
			return;
		}

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
		if ($user->admin) {
			$acc->admin = (isset($_POST["admin"]) && $_POST["admin"]) ? true : false;
		}

		$err = $acc->errors();

		if (count($err) === 0) {
			Account::update($acc);
		}

		$path = "/accounts/{$acc->id}";
		$data = array();
		if (count($err) === 0) {
			$data["success"] = array("Muokkaus onnistui!");
		} else {
			$path .= "/edit";
			$data["errors"] = $err;
			$attr["password"] = $_POST["password"];
			$data["attr"] = $attr;
		}
		echo Redirect::view($path, $data)->render();
	}

	public static function delete($id) {
		$user = static::check_logged_in();
		$a = null;
		if ($user->id . "" === $id . "") {
			$a = $user;
		} else if ($user->admin) {
			$a = Account::find($id);
		} else {
			http_response_code(403);
			ErrorController::error("Toiminto ei ole sallittu!");
			return;
		}

		$path = "/accounts";
		$res = Account::delete($id);
		$data = array();
		if ($res) {
			$data["success"] = array("Käyttäjä poistettiin onnistuneesti!");
		} else {
			$data["errors"] = array("Käyttäjää ei voitu poistaa!");
		}
		echo Redirect::view($path, $data)->render();
	}
}
