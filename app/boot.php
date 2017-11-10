<?php
# Hakemisto, jossa index.php:mme elää
define("BASE_DIR", dirname($_SERVER["SCRIPT_NAME"]));
# Pyydetty URL
define("REQ_URL", substr_replace($_SERVER["REQUEST_URI"], "", 0, strlen(BASE_DIR)));
# Pyynnön metodi, GET/POST/PUT/DELETE
define("REQ_METHOD", $_SERVER["REQUEST_METHOD"]);
# Reitti paloina
define("APP_ROUTE", explode("/", explode("?", ltrim(REQ_URL, "/"))[0]));
