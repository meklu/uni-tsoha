<?php

class Account extends Model {
	public $id;
	public $nick;
	public $password;
	public $admin;

	function __construct($attr) {
		parent::__construct($attr);
	}

	static function all() {
		return static::_all();
	}

	static function find($id) {
		return static::_find($id);
	}

	static function save($object) {
		return static::_save($object, array(
			"nick" => PDO::PARAM_STR,
			"password" => PDO::PARAM_STR,
			"admin" => PDO::PARAM_BOOL,
		));
	}
}
