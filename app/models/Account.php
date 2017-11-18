<?php

class Account extends Model {
	public $id;
	public $nick;
	public $password;
	public $admin;

	function __construct($attr = array()) {
		parent::__construct($attr);
	}

	function all() {
		return $this->_all();
	}

	function find($id) {
		return $this->_find($id);
	}

	function save() {
		return $this->_save(array(
			"nick" => PDO::PARAM_STR,
			"password" => PDO::PARAM_STR,
			"admin" => PDO::PARAM_BOOL,
		));
	}
}
