<?php
# Hakemisto, jossa index.php:mme elää
define("BASE_DIR", dirname($_SERVER["SCRIPT_NAME"]));
# Pyydetty URL
define("REQ_URL", substr_replace($_SERVER["REQUEST_URI"], "", 0, strlen(BASE_DIR)));
# Pyynnön metodi, GET/POST/PUT/DELETE
define("REQ_METHOD", $_SERVER["REQUEST_METHOD"]);
# Reitti paloina
define("APP_ROUTE", explode("/", explode("?", ltrim(REQ_URL, "/"))[0]));

require __DIR__ . "/redirect.php";
require __DIR__ . "/router.php";
require __DIR__ . "/model.php";
require __DIR__ . "/view.php";
require __DIR__ . "/controller.php";
require __DIR__ . "/database.php";
require __DIR__ . "/asset.php";

spl_autoload_register(function ($class) {
	$dirs = array(
		"controllers",
		"models",
	);
	foreach ($dirs as $d) {
		$f = __DIR__ . "/../app/$d/$class.php";
		if (file_exists($f)) {
			require $f;
		}
	}
});

$router = new Router();

require __DIR__ . "/../config/config.php";
require __DIR__ . "/../config/routes.php";

session_name(strtolower(APP_NAME));
session_start();

$router->run();
