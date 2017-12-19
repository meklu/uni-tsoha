<?php

class CategoryController extends Controller {
	public static function index() {
		$user = static::check_logged_in();
		$data = Category::allForAccount($user->id);
		$bv = new View("base", array(
			"content" => new View("categories/list", array(
				"categories" => $data,
			)),
		));
		echo $bv->render();
	}

	public static function show($id) {
		$user = static::check_logged_in();
		$c = Category::find($id);
		if ($c && $c->account_id != $user->id) {
			$c = null;
		}
		if (!$c) {
			http_response_code(404);
		}
		$bv = new View("base", array(
			"content" => new View("categories/show", array(
				"category" => $c,
			)),
		));
		echo $bv->render();
	}

	public static function addview() {
		$user = static::check_logged_in();
		$bv = new View("base", array(
			"content" => new View("categories/add"),
		));
		echo $bv->render();
	}

	public static function add() {
		$user = static::check_logged_in();
		$attr = array();
		$attr["name"] = $_POST["name"];
		$attr["account_id"] = $user->id;

		$c = new Category($attr);
		$err = $c->errors();

		if (count($err) === 0) {
			Category::save($c);
		}

		$path = "/categories";
		$data = array();
		if (is_int($c->id)) {
			$path .= "/{$c->id}";
			$data["success"] = array("Luokitus luotu onnistuneesti!");
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
		$c = Category::find($id);
		if ($c && $c->account_id != $user->id) {
			$c = null;
		}
		if (!$c) {
			http_response_code(404);
		}
		$bv = new View("base", array(
			"content" => new View("categories/edit", array(
				"category" => $c,
			)),
		));
		echo $bv->render();
	}

	public static function edit($id) {
		$user = static::check_logged_in();
		$c = Category::find($id);
		if ($c && $c->account_id != $user->id) {
			$c = null;
		}
		if (!$c) {
			http_response_code(404);
		}

		$attr = array();
		$c->name = $_POST["name"];

		$err = $c->errors();

		if (count($err) === 0) {
			Category::update($c);
		}

		$path = "/categories/{$c->id}";
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

		$path = "/categories";
		$res = Category::deleteForAccount($id, $user->id);
		$data = array();
		if ($res) {
			$data["success"] = array("Luokitus poistettiin onnistuneesti!");
		} else {
			$data["errors"] = array("Luokitusta ei voitu poistaa!");
		}
		echo Redirect::view($path, $data)->render();
	}
}
