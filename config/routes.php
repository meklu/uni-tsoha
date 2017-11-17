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

$router->get("/dash", function () {
	HejsanController::dash();
});

$router->get("/tasks", function () {
	HejsanController::tasks();
});

$router->get("/tasks/add", function () {
	HejsanController::tasks_add();
});

$router->get("/users", function () {
	HejsanController::users();
});

$router->get("/users/add", function () {
	HejsanController::users_add();
});

$router->get("/accounts", function () {
	AccountController::index();
});

$router->get("/accounts/:id", function ($a) {
	AccountController::show($a["id"]);
});

$router->get("/accounts/add", function () {
	AccountController::addview();
});

$router->post("/accounts/add", function () {
	AccountController::add();
});

$router->get("/priorities", function () {
	HejsanController::priorities();
});

$router->get("/priorities/add", function () {
	HejsanController::priorities_add();
});

$router->get("/categories", function () {
	HejsanController::categories();
});

$router->get("/categories/add", function () {
	HejsanController::categories_add();
});
