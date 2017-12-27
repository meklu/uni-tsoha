<?php

class TaskController extends Controller {
	public static function index() {
		$user = static::check_logged_in();
		$tasks = Task::allForAccount($user->id);
		foreach ($tasks as $t) {
			Task::retrieveCategories($t, false);
		}
		$categories = Category::allForAccount($user->id);
		$priorities = Priority::allForAccount($user->id);
		$bv = new View("base", array(
			"content" => new View("tasks/list", array(
				"tasks" => $tasks,
				"categories" => $categories,
				"priorities" => $priorities,
			)),
		));
		echo $bv->render();
	}

	public static function show($id) {
		$user = static::check_logged_in();
		$t = Task::find($id);
		if ($t && $t->account_id != $user->id) {
			$t = null;
		}
		$p = null;
		if (!$t) {
			http_response_code(404);
		} else {
			Task::retrieveCategories($t);
			$p = Priority::find($t->priority_id);
		}
		$bv = new View("base", array(
			"content" => new View("tasks/show", array(
				"task" => $t,
				"priority" => $p,
			)),
		));
		echo $bv->render();
	}

	public static function addview() {
		$user = static::check_logged_in();
		$bv = new View("base", array(
			"content" => new View("tasks/add", array(
				"categories" => Category::allForAccount($user->id),
				"priorities" => Priority::allForAccount($user->id),
			)),
		));
		echo $bv->render();
	}

	public static function add() {
		$user = static::check_logged_in();
		$attr = array();
		$attr["task"] = $_POST["task"];
		$attr["priority_id"] = $_POST["priority_id"];
		$attr["account_id"] = $user->id;

		$attr["categories"] = array_values($_POST["categories"]);
		foreach ($attr["categories"] as $k => $v) {
			$attr["categories"][$k] = intval($v);
		}

		$t = new Task($attr);
		$err = $t->errors();

		if (count($err) === 0) {
			Task::save($t);
		}

		$path = "/tasks";
		$data = array();
		if (is_int($t->id)) {
			$path .= "/{$t->id}";
			$data["success"] = array("Askare luotu onnistuneesti!");
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
		$t = Task::find($id);
		if ($t && $t->account_id != $user->id) {
			$t = null;
		}
		$p = null;
		if (!$t) {
			http_response_code(404);
		} else {
			Task::retrieveCategories($t, false);
		}
		$bv = new View("base", array(
			"content" => new View("tasks/edit", array(
				"task" => $t,
				"categories" => Category::allForAccount($user->id),
				"priorities" => Priority::allForAccount($user->id),
			)),
		));
		echo $bv->render();
	}

	public static function edit($id) {
		$user = static::check_logged_in();
		$t = Task::find($id);
		if ($t && $t->account_id != $user->id) {
			$t = null;
		}
		if (!$t) {
			http_response_code(404);
		}

		$attr = array();
		$attr["task"] = $_POST["task"];
		$attr["priority_id"] = $_POST["priority_id"];
		$attr["account_id"] = $user->id;

		$attr["categories"] = array_values($_POST["categories"]);
		foreach ($attr["categories"] as $k => $v) {
			$attr["categories"][$k] = intval($v);
		}

		$t->setAttr($attr);
		$err = $t->errors();

		if (count($err) === 0) {
			Task::update($t);
		}

		$path = "/tasks/{$t->id}";
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
}
