<?php
/* Kirjautuminen */

$router->get("/", function () {
	Controller::check_logged_in();
	HejsanController::html(
		"Placeholder",
		"<h1>Moi!</h1>\n" .
		""
	);
});

$router->get("/login", function () {
	LoginController::loginview();
});

$router->post("/login", function () {
	LoginController::login();
});

$router->post("/logout", function () {
	LoginController::logout();
});

/* Tietueet */

/* Käyttäjät */
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

/* Tärkeysasteet */
$router->get("/priorities/:id", function ($a) {
	# ...$foo ei toimi string-avaimilla :D
	PriorityController::show(...array_values($a));
});

$router->get("/priorities/add", function () {
	PriorityController::addview();
});

$router->post("/priorities/add", function () {
	PriorityController::add();
});

$router->get("/priorities/:id/edit", function ($a) {
	PriorityController::editview(...array_values($a));
});

$router->post("/priorities/:id/edit", function ($a) {
	PriorityController::edit(...array_values($a));
});

$router->put("/priorities/:id/edit", function ($a) {
	PriorityController::edit(...array_values($a));
});

$router->get("/priorities/:id/delete", function ($a) {
	PriorityController::delete(...array_values($a));
});

$router->delete("/priorities/:id/delete", function ($a) {
	PriorityController::delete(...array_values($a));
});

$router->get("/priorities", function () {
	PriorityController::index();
});

/* Luokitukset */
$router->get("/categories/:id", function ($a) {
	CategoryController::show(...array_values($a));
});

$router->get("/categories/add", function () {
	CategoryController::addview();
});

$router->post("/categories/add", function () {
	CategoryController::add();
});

$router->get("/categories/:id/edit", function ($a) {
	CategoryController::editview(...array_values($a));
});

$router->post("/categories/:id/edit", function ($a) {
	CategoryController::edit(...array_values($a));
});

$router->put("/categories/:id/edit", function ($a) {
	CategoryController::edit(...array_values($a));
});

$router->get("/categories/:id/delete", function ($a) {
	CategoryController::delete(...array_values($a));
});

$router->delete("/categories/:id/delete", function ($a) {
	CategoryController::delete(...array_values($a));
});

$router->get("/categories", function () {
	CategoryController::index();
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
