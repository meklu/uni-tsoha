<?php

class Account extends Model {
	public $id;
	public $nick;
	public $password;
	public $admin;

	function __construct($attr) {
		parent::__construct($attr);
		$this->validators = array(
			"validate_nick",
		);
	}

	function validate_nick() {
		$err = array();
		$min = 3;
		if (!$this->validate_strlen_min($this->nick, $min)) {
			$err[] = "Nimimerkin tulee olla vähintään {$min} merkin pituinen!";
		}
		$max = 64;
		if (!$this->validate_strlen_max($this->nick, $max)) {
			$err[] = "Nimimerkki saa olla enintään {$max} merkin pituinen!";
		}
		return $err;
	}

	static function all() {
		return static::_all("nick");
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

	static function update($object) {
		return static::_update($object, array(
			"nick" => PDO::PARAM_STR,
			"password" => PDO::PARAM_STR,
			"admin" => PDO::PARAM_BOOL,
		));
	}

	static function delete($id) {
		return static::_delete($id);
	}
}
