<?php

class ErrorController extends Controller {
	public static function error($message) {
		$bv = new View("base", array(
			"content" => new View("errors/basic", array(
				"code" => http_response_code(),
				"message" => $message,
			)),
		));
		echo $bv->render();
	}
}
