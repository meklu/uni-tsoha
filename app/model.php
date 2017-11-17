<?php

class Model {
	function __construct($attr = array()) {
		foreach ($attr as $k => $v) {
			if (property_exists($this, $k)) {
				$this->{$k} = $v;
			}
		}
	}

	function errors() {
		$ret = array();

		foreach ($this->validators as $v) {
			$r = $v();
			if ($r !== true) {
				$ret[] = $r;
			}
		}

		return $ret;
	}

	protected function _all() {
		$db = Database::conn();
		$q = $db->prepare("SELECT * FROM " . static::class);
		$q->execute();

		$rows = $q->fetchAll(PDO::FETCH_ASSOC);
		$ret = array();

		foreach ($rows as $row) {
			$ret[] = new static($row);
		}

		return $ret;
	}

	protected function _find($id) {
		$db = Database::conn();
		$q = $db->prepare("SELECT * FROM " . static::class . " WHERE id = :id LIMIT 1");
		$q->bindValue(":id", $id, PDO::PARAM_INT);
		$q->execute();

		$row = $q->fetch(PDO::FETCH_ASSOC);
		if (!$row) {
			return null;
		}

		return new static($row);
	}
}