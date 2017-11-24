<?php
$router->get("/accounts/:id", function ($a) {
	# ...$foo ei toimi string-avaimilla :D
	AccountController::show(...array_values($a));
});

$router->get("/accounts/add", function () {
	AccountController::addview();
});

$router->post("/accounts/add", function () {
	AccountController::add();
});

$router->get("/accounts/:id/edit", function ($a) {
	AccountController::editview(...array_values($a));
});

$router->post("/accounts/:id/edit", function ($a) {
	AccountController::edit(...array_values($a));
});

$router->put("/accounts/:id/edit", function ($a) {
	AccountController::edit(...array_values($a));
});

$router->get("/accounts/:id/delete", function ($a) {
	AccountController::delete(...array_values($a));
});

$router->delete("/accounts/:id/delete", function ($a) {
	AccountController::delete(...array_values($a));
});

$router->get("/accounts", function () {
	AccountController::index();
});

/* Virheet */
$router->error(403, function ($e) {
	ErrorController::error($e->getMessage());
});

$router->error(404, function ($e) {
	ErrorController::error($e->getMessage());
});

$router->error(500, function ($e) {
	ErrorController::error($e->getMessage());
});

/* Testijuttu */

$router->get("/psufh", function () {
	HejsanController::psufh();
});

/* Mockupit */

$router->get("/", function () {
	Redirect::to("/mock/login");
});

$router->get("/mock/login", function () {
	HejsanController::login();
});

$router->get("/mock/dash", function () {
	HejsanController::dash();
});

$router->get("/mock/tasks", function () {
	HejsanController::tasks();
});

$router->get("/mock/tasks/add", function () {
	HejsanController::tasks_add();
});

$router->get("/mock/users", function () {
	HejsanController::users();
});

$router->get("/mock/users/add", function () {
	HejsanController::users_add();
});

$router->get("/mock/priorities", function () {
	HejsanController::priorities();
});

$router->get("/mock/priorities/add", function () {
	HejsanController::priorities_add();
});

$router->get("/mock/categories", function () {
	HejsanController::categories();
});

$router->get("/mock/categories/add", function () {
	HejsanController::categories_add();
});
