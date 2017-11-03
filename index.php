<?php

# Hakemisto, jossa index.php:mme elää
define("BASE_DIR", dirname($_SERVER["SCRIPT_NAME"]));

define("REQ_URL", substr_replace($_SERVER["REQUEST_URI"], "", 0, strlen(BASE_DIR)));

define("APP_ROUTE", explode("/", explode("?", ltrim(REQ_URL, "/"))[0]));

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Fsuh</title>
	</head>
	<body>
		<h1>Psufh</h1>
		<p><?php echo time(); ?></p>
		<pre><?php echo 'BASE_DIR = ' . htmlspecialchars(var_export(BASE_DIR, true)) . "\n"; ?></pre>
		<pre><?php echo 'REQ_URL = ' . htmlspecialchars(var_export(REQ_URL, true)) . "\n"; ?></pre>
		<pre><?php echo 'APP_ROUTE = ' . htmlspecialchars(var_export(APP_ROUTE, true)) . "\n"; ?></pre>
	</body>
</html>
