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
		$db = Database::conn();
		$q = $db->prepare("INSERT INTO Account (nick, password, admin) VALUES (:nick, :password, :admin) RETURNING id");
		$q->bindValue(":nick", $this->nick, PDO::PARAM_STR);
		$q->bindValue(":password", $this->password, PDO::PARAM_STR);
		$q->bindValue(":admin", $this->admin, PDO::PARAM_BOOL);
		$q->execute();

		$row = $q->fetch(PDO::FETCH_ASSOC);
		if (!$row) {
			return null;
		}

		$this->id = $row["id"];
		return $this;
	}
}
