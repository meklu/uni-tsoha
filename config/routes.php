<?php
$router->get("/", function () {
	Redirect::to("/login");
});

$router->get("/psufh", function () {
	HejsanController::psufh();
});

$router->get("/login", function () {
	HejsanController::login();
});
