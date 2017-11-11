<?php

class HejsanController extends Controller {
	public static function psufh() {
		$bv = new View("base");
		$bv->setParam("content", new View("psufh"));
		echo $bv->render();
	}

	public static function login() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/login"));
		echo $bv->render();
	}

	public static function dash() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/dash"));
		echo $bv->render();
	}

	public static function tasks() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/tasks/list"));
		echo $bv->render();
	}

	public static function tasks_add() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/tasks/add"));
		echo $bv->render();
	}

	public static function users() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/users/list"));
		echo $bv->render();
	}

	public static function users_add() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/users/add"));
		echo $bv->render();
	}

	public static function priorities() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/priorities/list"));
		echo $bv->render();
	}

	public static function priorities_add() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/priorities/add"));
		echo $bv->render();
	}

	public static function categories() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/categories/list"));
		echo $bv->render();
	}

	public static function categories_add() {
		$bv = new View("base");
		$bv->setParam("content", new View("mockup/categories/add"));
		echo $bv->render();
	}
}
