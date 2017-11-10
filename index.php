<?php

require __DIR__ . "/app/boot.php";

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
		<pre><?php echo 'REQ_METHOD = ' . htmlspecialchars(var_export(REQ_METHOD, true)) . "\n"; ?></pre>
		<pre><?php echo 'APP_ROUTE = ' . htmlspecialchars(var_export(APP_ROUTE, true)) . "\n"; ?></pre>
	</body>
</html>
