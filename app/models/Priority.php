<?php

class Priority extends Model {
	public $id;
	public $account_id;
	public $priority;
	public $name;

	function __construct($attr) {
		parent::__construct($attr);
		$this->validators = array();
	}

	static function all() {
		return static::_all();
	}

	static function allForAccount($acc_id) {
		return static::_allByField("account_id", $acc_id, PDO::PARAM_INT);
	}

	static function find($id) {
		return static::_find($id);
	}

	static function save($object) {
		return static::_save($object, array(
			"account_id" => PDO::PARAM_INT,
			"priority" => PDO::PARAM_INT,
			"name" => PDO::PARAM_STR,
		));
	}

	static function update($object) {
		return static::_update($object, array(
			"account_id" => PDO::PARAM_INT,
			"priority" => PDO::PARAM_INT,
			"name" => PDO::PARAM_STR,
		));
	}

	static function delete($id) {
		return static::_delete($id);
	}

	static function deleteForAccount($id, $account_id) {
		return static::_deleteWhere($id, "account_id", $account_id, PDO::PARAM_INT);
	}
}
