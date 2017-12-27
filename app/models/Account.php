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

	function verifyPassword($plain) {
		return password_verify($plain, $this->password);
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

	static function _validate_plaintext_password($password) {
		$err = array();
		if (strlen($password) === 0) {
			$err[] = "Salasana ei saa olla tyhjä!";
		}
		return $err;
	}

	static function all() {
		return static::_all("nick");
	}

	static function find($id) {
		return static::_find($id);
	}

	static function findByNick($nick) {
		return static::_findByField("nick", $nick, PDO::PARAM_STR);
	}

	static function save($object) {
		return static::_save($object, array(
			"nick" => PDO::PARAM_STR,
			"password" => PDO::PARAM_STR,
			"admin" => PDO::PARAM_BOOL,
		));
	}

	static function update($object) {
		$db = Database::conn();
		if (!$db->beginTransaction()) {
			return false;
		}
		$r = true;
		$ret = static::_update($object, array(
			"nick" => PDO::PARAM_STR,
			"password" => PDO::PARAM_STR,
			"admin" => PDO::PARAM_BOOL,
		));
		$r = $r && $ret;
		/* Varmistetaan, että järjestelmään jää ainakin yksi ylläpitäjä */
		if (null === static::_findByField("admin", true, PDO::PARAM_BOOL)) {
			$db->rollBack();
			return null;
		}
		$r = $r && $db->commit();
		if (!$r) {
			$ret = null;
		}
		return $ret;
	}

	static function delete($id) {
		$db = Database::conn();
		if (!$db->beginTransaction()) {
			return false;
		}
		$ret = static::_delete($id);
		/* Varmistetaan, että järjestelmään jää ainakin yksi ylläpitäjä */
		if (null === static::_findByField("admin", true, PDO::PARAM_BOOL)) {
			$db->rollBack();
			return false;
		}
		$ret = $ret && $db->commit();
		return $ret;
	}
}
