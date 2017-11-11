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
}
