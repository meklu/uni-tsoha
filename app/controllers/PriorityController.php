<?php

class PriorityController extends Controller {
	public static function index() {
		$user = static::check_logged_in();
		$data = Priority::allForAccount($user->id);
		$bv = new View("base", array(
			"content" => new View("priorities/list", array(
				"priorities" => $data,
			)),
		));
		echo $bv->render();
	}

	public static function show($id) {
		$user = static::check_logged_in();
		$p = Priority::find($id);
		if ($p && $p->account_id != $user->id) {
			$p = null;
		}
		if (!$p) {
			http_response_code(404);
		}
		$bv = new View("base", array(
			"content" => new View("priorities/show", array(
				"priority" => $p,
			)),
		));
		echo $bv->render();
	}

	public static function addview() {
		$user = static::check_logged_in();
		$bv = new View("base", array(
			"content" => new View("priorities/add"),
		));
		echo $bv->render();
	}

	public static function add() {
		$user = static::check_logged_in();
		$attr = array();
		$attr["name"] = $_POST["name"];
		$attr["priority"] = intval($_POST["priority"]);
		$attr["account_id"] = $user->id;

		$p = new Priority($attr);
		$err = $p->errors();

		if (count($err) === 0) {
			Priority::save($p);
		}

		$path = "/priorities";
		$data = array();
		if (is_int($p->id)) {
			$path .= "/{$p->id}";
			$data["success"] = array("Tärkeysaste luotu onnistuneesti!");
		} else {
			$path .= "/add";
			if (count($err) === 0) {
				$err[] = "Tietokantavirhe";
			}
			$data["errors"] = $err;
			$data["attr"] = $attr;
		}
		echo Redirect::view($path, $data)->render();
	}

	public static function editview($id) {
		$user = static::check_logged_in();
		$p = Priority::find($id);
		if ($p && $p->account_id != $user->id) {
			$p = null;
		}
		if (!$p) {
			http_response_code(404);
		}
		$bv = new View("base", array(
			"content" => new View("priorities/edit", array(
				"priority" => $p,
			)),
		));
		echo $bv->render();
	}

	public static function edit($id) {
		$user = static::check_logged_in();
		$p = Priority::find($id);
		if ($p && $p->account_id != $user->id) {
			$p = null;
		}
		if (!$p) {
			http_response_code(404);
		}

		$attr = array();
		$attr["name"] = $_POST["name"];
		$attr["priority"] = intval($_POST["priority"]);

		$p->setAttr($attr);
		$err = $p->errors();

		if (count($err) === 0) {
			$ret = Priority::update($p);
			if (!$ret) {
				$err[] = "Muokkaus epäonnistui!";
			}
		}

		$path = "/priorities/{$p->id}";
		$data = array();
		if (count($err) === 0) {
			$data["success"] = array("Muokkaus onnistui!");
		} else {
			$path .= "/edit";
			$data["errors"] = $err;
			$data["attr"] = $attr;
		}
		echo Redirect::view($path, $data)->render();
	}

	public static function delete($id) {
		$user = static::check_logged_in();

		$path = "/priorities";
		$res = Priority::deleteForAccount($id, $user->id);
		$data = array();
		if ($res) {
			$data["success"] = array("Tärkeysaste poistettiin onnistuneesti!");
		} else {
			$data["errors"] = array("Tärkeysastetta ei voitu poistaa!");
		}
		echo Redirect::view($path, $data)->render();
	}
}
